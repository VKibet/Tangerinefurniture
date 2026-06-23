<!-- Footer Navigation Bar -->
<div class="bg-gray-800 border-t border-gray-700 py-5">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex flex-wrap justify-center md:justify-start gap-6">
                <a href="{{ route('pages.about') }}" class="text-gray-300 hover:text-white text-sm font-medium transition-colors">About Tangerine</a>
                <a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white text-sm font-medium transition-colors">Shop</a>
                <a href="{{ route('pages.contact') }}" class="text-gray-300 hover:text-white text-sm font-medium transition-colors">Contact</a>
            </div>
            <a href="{{ route('pages.contact') }}" class="inline-flex items-center space-x-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold text-sm transition-colors shadow-md">
                <i class="fas fa-paper-plane text-xs"></i>
                <span>Contact Us Now</span>
            </a>
        </div>
    </div>
</div>

<!-- Main Footer -->
<footer class="bg-gray-900 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Top Section: Brand + Columns -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">

            <!-- Brand Column -->
            <div class="space-y-4">
                <a href="{{ route('home') }}">
                    <h2 class="text-2xl font-extrabold tracking-tight text-white">TANGERINE <span class="text-orange-400">FURNITURE</span></h2>
                </a>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Quality furniture crafted for modern living. Serving Nairobi and beyond with elegant, durable pieces for every space.
                </p>
                <!-- Social Icons -->
                <div class="flex items-center space-x-3 pt-2">
                    <a href="{{ $settings['social_facebook'] ?? '#' }}" target="_blank" rel="noopener noreferrer"
                       class="w-9 h-9 rounded-lg bg-gray-700 hover:bg-blue-600 flex items-center justify-center text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="{{ $settings['social_twitter'] ?? '#' }}" target="_blank" rel="noopener noreferrer"
                       class="w-9 h-9 rounded-lg bg-gray-700 hover:bg-sky-500 flex items-center justify-center text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="{{ $settings['social_instagram'] ?? '#' }}" target="_blank" rel="noopener noreferrer"
                       class="w-9 h-9 rounded-lg bg-gray-700 hover:bg-pink-600 flex items-center justify-center text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="https://wa.me/254791708894" target="_blank" rel="noopener noreferrer"
                       class="w-9 h-9 rounded-lg bg-gray-700 hover:bg-green-600 flex items-center justify-center text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Our Locations -->
            <div class="space-y-4">
                <h3 class="text-base font-semibold text-white uppercase tracking-wider border-b border-gray-700 pb-2">Our Locations</h3>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="mt-0.5 flex-shrink-0 w-7 h-7 rounded-md bg-orange-500 bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-orange-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">Dul Dul Godowns</p>
                            <p class="text-gray-400 text-xs leading-relaxed">Phase 2, Cabanas Stage, Nairobi, Kenya</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="mt-0.5 flex-shrink-0 w-7 h-7 rounded-md bg-orange-500 bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-orange-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">Chaka Road Mall</p>
                            <p class="text-gray-400 text-xs leading-relaxed">Wing A, 3rd Floor, TL Chaka Rd, Nairobi, Kenya</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="space-y-4">
                <h3 class="text-base font-semibold text-white uppercase tracking-wider border-b border-gray-700 pb-2">Get In Touch</h3>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-7 h-7 rounded-md bg-orange-500 bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-phone text-orange-400 text-xs"></i>
                        </div>
                        <div class="space-y-0.5">
                            <a href="tel:0791708894" class="block text-gray-300 hover:text-white text-sm transition-colors">0791 708 894</a>
                            <a href="tel:0111305770" class="block text-gray-300 hover:text-white text-sm transition-colors">0111 305 770</a>
                            <a href="tel:0784256077" class="block text-gray-300 hover:text-white text-sm transition-colors">0784 256 077</a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-7 h-7 rounded-md bg-orange-500 bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-envelope text-orange-400 text-xs"></i>
                        </div>
                        <a href="mailto:info@tangerinefurniture.co.ke" class="text-gray-300 hover:text-white text-sm transition-colors">info@tangerinefurniture.co.ke</a>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-7 h-7 rounded-md bg-orange-500 bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-clock text-orange-400 text-xs"></i>
                        </div>
                        <span class="text-gray-400 text-sm">Mon – Sat &nbsp;9:00 am – 6:00 pm</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-700 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
            <p class="text-gray-500 text-xs">
                &copy;{{ date('Y') }} Tangerine Furniture. All Rights Reserved.
            </p>
            <p class="text-gray-600 text-xs">
                Designed &amp; built in Nairobi, Kenya
            </p>
        </div>

    </div>
</footer>
