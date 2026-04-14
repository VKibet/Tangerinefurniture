<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarouselSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselSlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = CarouselSlide::ordered()->get();
        return view('admin.carousel-slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.carousel-slides.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'background_color' => 'required|in:blue,green,purple,red,yellow,pink,indigo,gray',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('carousel-slides', 'public');
            $data['image'] = $imagePath;
        }

        $data['is_active'] = $request->has('is_active');
        $data['order'] = $data['order'] ?? CarouselSlide::max('order') + 1;

        CarouselSlide::create($data);

        return redirect()->route('admin.carousel-slides.index')
            ->with('success', 'Carousel slide created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarouselSlide $carouselSlide)
    {
        return view('admin.carousel-slides.show', compact('carouselSlide'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarouselSlide $carouselSlide)
    {
        return view('admin.carousel-slides.edit', compact('carouselSlide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarouselSlide $carouselSlide)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'background_color' => 'required|in:blue,green,purple,red,yellow,pink,indigo,gray',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($carouselSlide->image) {
                Storage::disk('public')->delete($carouselSlide->image);
            }

            $imagePath = $request->file('image')->store('carousel-slides', 'public');
            $data['image'] = $imagePath;
        }

        $data['is_active'] = $request->has('is_active');

        $carouselSlide->update($data);

        return redirect()->route('admin.carousel-slides.index')
            ->with('success', 'Carousel slide updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarouselSlide $carouselSlide)
    {
        // Delete image file
        if ($carouselSlide->image) {
            Storage::disk('public')->delete($carouselSlide->image);
        }

        $carouselSlide->delete();

        return redirect()->route('admin.carousel-slides.index')
            ->with('success', 'Carousel slide deleted successfully.');
    }

    /**
     * Toggle the active status of a slide.
     */
    public function toggleStatus(CarouselSlide $carouselSlide)
    {
        $carouselSlide->update(['is_active' => !$carouselSlide->is_active]);

        return redirect()->route('admin.carousel-slides.index')
            ->with('success', 'Slide status updated successfully.');
    }

    /**
     * Update the order of slides.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'slides' => 'required|array',
            'slides.*' => 'required|integer|exists:carousel_slides,id'
        ]);

        foreach ($request->slides as $index => $slideId) {
            CarouselSlide::where('id', $slideId)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
