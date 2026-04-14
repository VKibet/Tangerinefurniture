@extends('layouts.app')

@section('title', 'About Us - Tangerine Furniture Kenya')
@section('description', 'Learn about Tangerine Furniture, Kenya\'s premier furniture store. We provide quality furniture solutions for homes, offices, and commercial spaces.')
@section('keywords', 'about Tangerine Furniture, furniture company Kenya, furniture store Nairobi, quality furniture')

@section('content')
<div class="bg-gray-100 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">About Tangerine Furniture</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                We are Kenya's premier destination for quality furniture solutions, 
                committed to bringing beautiful and functional furniture to homes and businesses across the country.
            </p>
        </div>

        <!-- Company Story -->
        <div class="mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                    <p class="text-gray-600 mb-4">
                        Founded with a passion for quality craftsmanship, Tangerine Furniture started with a simple mission: 
                        to make beautiful, functional furniture accessible to everyone in Kenya. What began as a small 
                        furniture workshop has grown into one of the country's most trusted names in furniture retail.
                    </p>
                    <p class="text-gray-600 mb-4">
                        We believe that furniture should enhance living spaces, not just fill them. That's why we carefully 
                        curate our product selection, ensuring that every piece we offer meets our high standards for 
                        quality, durability, and aesthetic appeal.
                    </p>
                    <p class="text-gray-600">
                        Today, we serve thousands of satisfied customers across Kenya, providing not just furniture, 
                        but complete furnishing solutions and exceptional customer service.
                    </p>
                </div>
                <div class="border border-gray-200 rounded-lg p-8 bg-white shadow-sm">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-home text-yellow-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Our Mission</h3>
                        <p class="text-gray-600 leading-relaxed">
                            To transform living and working spaces by providing quality furniture that combines 
                            functionality, beauty, and affordability for all Kenyans.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Values -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Our Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="border border-gray-200 rounded-lg p-6 text-center bg-white shadow-sm">
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-tree text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Quality Materials</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        We use only the finest materials and craftsmanship. Every piece of furniture 
                        is built to last and designed to enhance your living space.
                    </p>
                </div>
                
                <div class="border border-gray-200 rounded-lg p-6 text-center bg-white shadow-sm">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Fast Delivery</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        We understand that furniture delivery matters. That's why we offer same-day 
                        delivery within Nairobi and reliable shipping across Kenya.
                    </p>
                </div>
                
                <div class="border border-gray-200 rounded-lg p-6 text-center bg-white shadow-sm">
                    <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-palette text-yellow-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Beautiful Design</h3>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        We believe furniture should be both functional and beautiful. Our designs 
                        combine modern aesthetics with timeless appeal.
                    </p>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="mb-16">
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-lg p-8 text-white">
                <h2 class="text-3xl font-bold text-center mb-8">Our Impact</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <div class="text-3xl font-bold mb-2">5,000+</div>
                        <div class="text-gray-300 text-sm">Happy Customers</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold mb-2">15,000+</div>
                        <div class="text-gray-300 text-sm">Furniture Pieces Sold</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold mb-2">50+</div>
                        <div class="text-gray-300 text-sm">Furniture Categories</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold mb-2">5+</div>
                        <div class="text-gray-300 text-sm">Years Experience</div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>



        <!-- Why Choose Us -->
        <div>
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Why Choose Tangerine Furniture?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-orange-600 text-lg"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 mb-2">Fast Delivery</h3>
                    <p class="text-gray-600 text-sm">Same day delivery within Nairobi</p>
                </div>
                
                <div class="text-center">
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-undo text-green-600 text-lg"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 mb-2">Quality Materials</h3>
                    <p class="text-gray-600 text-sm">Premium materials and craftsmanship</p>
                </div>
                
                <div class="text-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-blue-600 text-lg"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 mb-2">Expert Support</h3>
                    <p class="text-gray-600 text-sm">Professional design consultation</p>
                </div>
                
                <div class="text-center">
                    <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-purple-600 text-lg"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 mb-2">Flexible Payment</h3>
                    <p class="text-gray-600 text-sm">Installment plans available</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 