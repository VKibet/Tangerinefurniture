<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $category->load('products');
        $availableProducts = Product::with('category:id,name')
            ->where('category_id', '!=', $category->id)
            ->orderBy('name')
            ->get(['id', 'name', 'price', 'image', 'category_id']);
        $allCategories = Category::orderBy('name')->get(['id', 'name']);
        return view('admin.categories.show', compact('category', 'availableProducts', 'allCategories'));
    }

    public function assignProducts(Request $request, Category $category)
    {
        $validated = $request->validate([
            'product_ids'   => 'required|array|min:1',
            'product_ids.*' => 'exists:products,id',
        ]);

        $count = Product::whereIn('id', $validated['product_ids'])
            ->update(['category_id' => $category->id]);

        return back()->with('success', $count . ' product(s) assigned to "' . $category->name . '" successfully.');
    }

    public function removeProduct(Request $request, Category $category)
    {
        $validated = $request->validate([
            'product_id'      => 'required|exists:products,id',
            'new_category_id' => 'nullable|exists:categories,id',
        ]);

        $newCategoryId = $validated['new_category_id'] ?? null;
        Product::where('id', $validated['product_id'])
            ->where('category_id', $category->id)
            ->update(['category_id' => $newCategoryId]);

        return back()->with('success', 'Product moved successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing products.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:categories,id',
            'categories.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->categories as $categoryData) {
            Category::where('id', $categoryData['id'])->update(['sort_order' => $categoryData['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
} 