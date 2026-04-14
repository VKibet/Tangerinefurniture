<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;
        
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $cartItems[] = [
                    'id' => $productId,
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity']
                ];
                $total += $product->price * $item['quantity'];
            }
        }
        
        return view('cart.index', compact('cartItems', 'total'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $quantity;
        } else {
            $cart[$request->product_id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->main_image_url,
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => count($cart),
            'cart_total' => $this->getCartTotal($cart)
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart!',
            'cart_count' => count($cart),
            'cart_total' => $this->getCartTotal($cart)
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cart_count' => count($cart),
            'cart_total' => $this->getCartTotal($cart)
        ]);
    }

    public function clear()
    {
        session()->forget('cart');
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared!'
        ]);
    }

    public function getCartData()
    {
        $cart = session()->get('cart', []);
        
        // Update image URLs for existing cart items to ensure they have full URLs
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product && isset($item['image'])) {
                // Update the image URL to use the full URL
                $cart[$productId]['image'] = $product->main_image_url;
            }
        }
        
        // Update the session with corrected image URLs
        session()->put('cart', $cart);
        
        return response()->json([
            'cart' => $cart,
            'cart_count' => count($cart),
            'cart_total' => $this->getCartTotal($cart)
        ]);
    }
    
    public function checkout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'delivery_notes' => 'nullable|string'
        ]);
        
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }
        
        try {
            DB::beginTransaction();
            
            // Calculate total and prepare items
            $cartItems = [];
            $total = 0;
            
            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);
                if ($product) {
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'subtotal' => $product->price * $item['quantity']
                    ];
                    $total += $product->price * $item['quantity'];
                }
            }
            
            // Create order
            $order = Order::create([
                'user_id' => auth()->id() ?? 1, // Use guest user ID 1 if not authenticated
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'cash_on_delivery',
                'shipping_address' => $request->address . ', ' . $request->city . ', ' . $request->postal_code,
                'billing_address' => $request->address . ', ' . $request->city . ', ' . $request->postal_code,
                'phone' => $request->phone,
                'notes' => $request->delivery_notes,
            ]);
            
            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['product']->price,
                    'total' => $item['subtotal'],
                ]);
            }
            
            DB::commit();
            
            // Send email notifications
            $this->sendOrderEmail($order, $cartItems);
            
            // Clear cart
            session()->forget('cart');
            
            return redirect()->route('cart.index')->with('success', 'Order placed successfully! Order #' . $order->order_number . '. We will contact you soon.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'There was an error processing your order. Please try again.');
        

                    //Testing real error
            //     } catch (\Exception $e) {
            // DB::rollBack();

            // dd(
            //     $e->getMessage(),
            //     $e->getFile(),
            //     $e->getLine()
            // );
}
    }
    
    private function sendOrderEmail($order, $cartItems)
    {
        $adminEmail = config('mail.admin_email', 'victordakibet@gmail.com');
        
        // Send email to admin
        Mail::send('emails.new-order', [
            'order' => $order,
            'items' => $cartItems,
            'customer_name' => $order->user->name ?? 'Guest',
            'customer_email' => $order->user->email ?? 'guest@example.com',
        ], function($message) use ($adminEmail, $order) {
            $message->to($adminEmail)
                    ->subject('New Order Received - ' . $order->order_number);
        });
        
        // Send confirmation email to customer
        $customerEmail = $order->user->email ?? 'guest@example.com';
        Mail::send('emails.order-confirmation', [
            'order' => $order,
            'items' => $cartItems,
        ], function($message) use ($customerEmail, $order) {
            $message->to($customerEmail)
                    ->subject('Order Confirmation - ' . $order->order_number);
        });
    }

    private function getCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
} 