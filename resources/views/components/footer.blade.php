<!-- Footer Navigation -->
<div class="bg-gray-900 py-6">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="flex space-x-8 mb-4 md:mb-0">
                <a href="{{ route('pages.about') }}" class="text-white hover:text-gray-300">About Tangerine</a>
                <a href="{{ route('products.index') }}" class="text-white hover:text-gray-300">Shop</a>
            </div>
            <a href="{{ route('pages.contact') }}" class="bg-green-600 text-white px-6 py-3 font-semibold hover:bg-green-700 transition-colors">
                Contact Us Now
            </a>
        </div>
    </div>
</div>

<!-- Main Footer -->
<footer class="bg-gray-900 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Get In Touch Section -->
        <div class="mb-4">
            <h3 class="text-2xl font-bold mb-6">Get In Touch</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Addresses -->
                <div class="space-y-2">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-white mt-1"></i>
                        <div>
                            <p class="text-gray-300">DUL DUL GODOWNS 2, PHASE 2, CABANAS STAGE</p>
                            <p class="text-gray-300">Nairobi, Kenya.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-white mt-1"></i>
                        <div>
                            <p class="text-gray-300">CHAKA ROAD MALL, WING A 3rd FLOOR TL CHAKA RD</p>
                            <p class="text-gray-300">Nairobi, Kenya.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-phone text-white"></i>
<a href="tel:0791708804">0791 708 894</a>                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-phone text-white"></i>
<a href="tel:0111305776">0111 305 776</a>                    </div>
                                        <div class="flex items-center space-x-3">
                        <i class="fas fa-phone text-white"></i>
<a href="tel:0784256077">0784 256 077</a>                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-white"></i>
<a href="mailto:info@tangerinefurniture.co.ke">info@tangerinefurniture.co.ke</a>                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-clock text-white"></i>
                        <span class="text-gray-300">Monday - Saturday 9:00 am - 6:00 pm</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Section -->
        <div class="border-t border-gray-700 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
<p class="text-gray-400 text-sm">©{{ date('Y') }} Tangerine Furniture. All Rights Reserved.</p>            
                </div>
                
                <!-- Social Media Icons -->
                <div class="flex space-x-4">
                    <a href="{{ $settings['social_facebook'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                    <a href="{{ $settings['social_twitter'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="{{ $settings['social_instagram'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer> 
