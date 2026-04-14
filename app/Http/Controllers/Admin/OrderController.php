<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update(['payment_status' => $request->payment_status]);

        return back()->with('success', 'Payment status updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }

    public function exportCsv(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product']);

        // Apply the same filters as the index method
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->get();

        // Generate filename with date range info if applicable
        $filename = 'orders_export_' . now()->format('Y-m-d_H-i-s');
        if ($request->filled('date_from') || $request->filled('date_to')) {
            $from = $request->filled('date_from') ? $request->date_from : 'all';
            $to = $request->filled('date_to') ? $request->date_to : 'all';
            $filename .= '_' . $from . '_to_' . $to;
        }
        $filename .= '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'Order Number',
                'Order Date',
                'Customer Name',
                'Customer Email',
                'Customer Phone',
                'Product Name',
                'Product SKU',
                'Product Brand',
                'Quantity',
                'Unit Price (KES)',
                'Total Price (KES)',
                'Order Status',
                'Payment Status',
                'Payment Method',
                'Shipping Address',
                'Billing Address',
                'Order Notes'
            ]);

            // CSV Data - Each row represents an order item
            foreach ($orders as $order) {
                if ($order->orderItems->count() > 0) {
                    foreach ($order->orderItems as $item) {
                        fputcsv($file, [
                            $order->order_number,
                            $order->created_at->format('Y-m-d H:i:s'),
                            $order->user->name ?? 'Guest',
                            $order->user->email ?? 'guest@example.com',
                            $order->phone ?? '',
                            $item->product->name ?? 'Product Deleted',
                            $item->product->slug ?? '',
                            $item->product->brand ?? '',
                            $item->quantity,
                            number_format($item->price, 2),
                            number_format($item->total, 2),
                            ucfirst($order->status),
                            ucfirst($order->payment_status),
                            ucfirst($order->payment_method ?? 'N/A'),
                            $order->shipping_address ?? '',
                            $order->billing_address ?? '',
                            $order->notes ?? ''
                        ]);
                    }
                } else {
                    // Handle orders with no items (shouldn't happen but just in case)
                    fputcsv($file, [
                        $order->order_number,
                        $order->created_at->format('Y-m-d H:i:s'),
                        $order->user->name ?? 'Guest',
                        $order->user->email ?? 'guest@example.com',
                        $order->phone ?? '',
                        'No Items',
                        '',
                        '',
                        0,
                        '0.00',
                        '0.00',
                        ucfirst($order->status),
                        ucfirst($order->payment_status),
                        ucfirst($order->payment_method ?? 'N/A'),
                        $order->shipping_address ?? '',
                        $order->billing_address ?? '',
                        $order->notes ?? ''
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 