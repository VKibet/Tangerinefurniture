<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::ordered()->paginate(15);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $categories = [
            'general' => 'General',
            'ordering' => 'Ordering',
            'shipping' => 'Shipping',
            'returns' => 'Returns',
            'technical' => 'Technical'
        ];
        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'required|string|in:general,ordering,shipping,returns,technical',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ created successfully.');
    }

    public function edit(Faq $faq)
    {
        $categories = [
            'general' => 'General',
            'ordering' => 'Ordering',
            'shipping' => 'Shipping',
            'returns' => 'Returns',
            'technical' => 'Technical'
        ];
        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'required|string|in:general,ordering,shipping,returns,technical',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ deleted successfully.');
    }

    public function toggleStatus(Faq $faq)
    {
        $faq->update(['is_active' => !$faq->is_active]);
        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ status updated successfully.');
    }
} 