@extends('layouts.admin')

@section('title', 'Category: {{ $category->name }}')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                @if($category->icon)<i class="{{ $category->icon }} text-orange-500"></i>@endif
                {{ $category->name }}
            </h1>
            <p class="text-gray-500 text-sm mt-0.5">Manage products assigned to this category</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.categories.edit', $category) }}"
               class="inline-flex items-center gap-1.5 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                <i class="fas fa-edit text-xs"></i> Edit Category
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                <i class="fas fa-arrow-left text-xs"></i> Back
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <i class="fas fa-exclamation-circle text-red-500"></i> {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT: Products in this category -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Stats bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $category->products->count() }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Total Products</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $category->products->where('is_active', true)->count() }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Active</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ $category->products->where('is_featured', true)->count() }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Featured</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
                    <p class="text-2xl font-bold text-red-500">{{ $category->products->where('stock_quantity', '<', 10)->count() }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Low Stock</p>
                </div>
            </div>

            <!-- Current products -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-900">
                        Products in <span class="text-orange-500">{{ $category->name }}</span>
                        <span class="ml-1 text-sm font-normal text-gray-400">({{ $category->products->count() }})</span>
                    </h2>
                    <a href="{{ route('admin.products.create') }}"
                       class="inline-flex items-center gap-1 text-xs bg-orange-50 text-orange-600 border border-orange-200 px-3 py-1.5 rounded-lg hover:bg-orange-100 transition-colors font-medium">
                        <i class="fas fa-plus"></i> Add New Product
                    </a>
                </div>

                @if($category->products->count() > 0)
                    <div class="divide-y divide-gray-50">
                        @foreach($category->products as $product)
                        <div class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition-colors group">
                            <!-- Thumbnail -->
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg overflow-hidden bg-gray-100">
                                @if($product->image)
                                    <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-image text-gray-300 text-sm"></i>
                                    </div>
                                @endif
                            </div>
                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->formatted_price }}</p>
                            </div>
                            <!-- Status -->
                            <span class="flex-shrink-0 inline-flex px-2 py-0.5 text-xs font-medium rounded-full
                                {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <!-- Actions -->
                            <div class="flex-shrink-0 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="text-blue-500 hover:text-blue-700 p-1.5 rounded hover:bg-blue-50 transition-colors" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <!-- Move to another category -->
                                <button type="button"
                                        onclick="openMoveModal({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                        class="text-orange-500 hover:text-orange-700 p-1.5 rounded hover:bg-orange-50 transition-colors" title="Move to another category">
                                    <i class="fas fa-exchange-alt text-xs"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 px-6">
                        <i class="fas fa-box-open text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500 font-medium">No products in this category yet</p>
                        <p class="text-gray-400 text-sm mt-1">Use the panel on the right to assign existing products, or add a new one.</p>
                    </div>
                @endif
            </div>

        </div>

        <!-- RIGHT: Assign products panel -->
        <div class="space-y-5">

            <!-- Category info -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 space-y-3">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Category Info</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Slug</span>
                        <code class="text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-600">{{ $category->slug }}</code>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status</span>
                        <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full
                            {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @if($category->icon)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Icon</span>
                        <span class="flex items-center gap-1.5 text-gray-600">
                            <i class="{{ $category->icon }}"></i>
                            <span class="text-xs">{{ $category->icon }}</span>
                        </span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-500">Sort Order</span>
                        <span class="text-gray-700">{{ $category->sort_order ?? 0 }}</span>
                    </div>
                </div>
                @if($category->description)
                    <p class="text-xs text-gray-500 border-t border-gray-100 pt-3">{{ $category->description }}</p>
                @endif
            </div>

            <!-- Assign Products Panel -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200" x-data="assignPanel()" x-init="init()">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Assign Products to This Category</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $availableProducts->count() }} product(s) in other categories</p>
                </div>

                @if($availableProducts->count() > 0)
                <div class="p-4 space-y-3">
                    <!-- Search -->
                    <input type="text"
                           x-model="search"
                           placeholder="Search products..."
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none">

                    <!-- Select All -->
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <label class="flex items-center gap-1.5 cursor-pointer select-none">
                            <input type="checkbox" x-model="selectAll" @change="toggleAll()" class="rounded text-orange-500">
                            <span>Select all visible</span>
                        </label>
                        <span x-text="selected.length + ' selected'" class="font-medium text-gray-700"></span>
                    </div>

                    <!-- Product list -->
                    <div class="max-h-64 overflow-y-auto space-y-1 border border-gray-100 rounded-lg p-2">
                        @foreach($availableProducts as $product)
                        <label
                            x-show="search === '' || '{{ strtolower($product->name) }}'.includes(search.toLowerCase())"
                            class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-orange-50 cursor-pointer transition-colors"
                            :class="selected.includes({{ $product->id }}) ? 'bg-orange-50' : ''">
                            <input type="checkbox"
                                   value="{{ $product->id }}"
                                   x-model="selected"
                                   class="rounded text-orange-500 flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-800 truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-400">
                                    KES {{ number_format($product->price) }}
                                    @if($product->category)
                                        &middot; <span class="italic">{{ $product->category->name }}</span>
                                    @endif
                                </p>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <!-- Submit -->
                    <form method="POST" action="{{ route('admin.categories.assign-products', $category) }}" id="assign-form">
                        @csrf
                        <template x-for="id in selected" :key="id">
                            <input type="hidden" name="product_ids[]" :value="id">
                        </template>
                        <button type="submit"
                                :disabled="selected.length === 0"
                                class="w-full py-2.5 rounded-lg text-sm font-semibold transition-colors
                                    bg-orange-500 text-white hover:bg-orange-600
                                    disabled:opacity-40 disabled:cursor-not-allowed">
                            <span x-text="selected.length === 0 ? 'Select products first' : 'Assign ' + selected.length + ' Product(s)'"></span>
                        </button>
                    </form>
                </div>
                @else
                    <div class="text-center py-8 px-4">
                        <i class="fas fa-check-circle text-green-300 text-3xl mb-2"></i>
                        <p class="text-gray-500 text-sm">All products are already in this category or another.</p>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 space-y-2">
                <a href="{{ route('admin.categories.edit', $category) }}"
                   class="flex items-center justify-center gap-2 w-full text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                    <i class="fas fa-edit text-xs"></i> Edit Category
                </a>
                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Delete this category? Products will need to be reassigned.')"
                            class="flex items-center justify-center gap-2 w-full text-center bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                        <i class="fas fa-trash text-xs"></i> Delete Category
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Move Product Modal -->
<div id="move-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6">
        <h3 class="text-base font-semibold text-gray-900 mb-1">Move Product</h3>
        <p class="text-sm text-gray-500 mb-4">Move <strong id="move-product-name"></strong> to another category.</p>
        <form method="POST" action="{{ route('admin.categories.remove-product', $category) }}" id="move-form">
            @csrf
            <input type="hidden" name="product_id" id="move-product-id">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Target Category</label>
                <select name="new_category_id" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">— Unassign (no category) —</option>
                    @foreach($allCategories as $cat)
                        @if($cat->id !== $category->id)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">Move</button>
                <button type="button" onclick="closeMoveModal()" class="flex-1 bg-gray-100 text-gray-700 py-2 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">Cancel</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function assignPanel() {
    return {
        search: '',
        selected: [],
        selectAll: false,
        init() {},
        toggleAll() {
            if (this.selectAll) {
                this.selected = @json($availableProducts->pluck('id'));
            } else {
                this.selected = [];
            }
        }
    };
}

function openMoveModal(productId, productName) {
    document.getElementById('move-product-id').value = productId;
    document.getElementById('move-product-name').textContent = productName;
    document.getElementById('move-modal').classList.remove('hidden');
}

function closeMoveModal() {
    document.getElementById('move-modal').classList.add('hidden');
}

document.getElementById('move-modal').addEventListener('click', function(e) {
    if (e.target === this) closeMoveModal();
});
</script>
@endpush

@endsection
