<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'KartCenter') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Racing+Sans+One&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'heading': ['Racing Sans One', 'cursive'],
                        'body': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'kart-red': '#E63946',
                        'kart-blue': '#1D3557',
                        'kart-light': '#F1FAEE',
                        'kart-cyan': '#A8DADC',
                    }
                }
            }
        }
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, rgba(29, 53, 87, 0.9) 0%, rgba(230, 57, 70, 0.8) 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body class="font-body text-gray-800 bg-kart-light">

    <!-- Navigation - DINAMIČKA NAVIGACIJA -->
    <nav class="sticky top-0 z-50 bg-kart-blue text-white shadow-xl">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-kart-red rounded-full flex items-center justify-center">
                        <i class="fas fa-flag-checkered text-white"></i>
                    </div>
                    <a href="{{ url('/') }}" class="text-3xl font-heading tracking-wide">KART<span class="text-kart-red">CENTER</span></a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ url('/') }}" class="hover:text-kart-cyan font-medium transition">Home</a>
                    <a href="#packages" class="hover:text-kart-cyan font-medium transition">Packages</a>
                    <a href="#about" class="hover:text-kart-cyan font-medium transition">About</a>
                    <a href="#contact" class="hover:text-kart-cyan font-medium transition">Contact</a>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="hover:text-kart-cyan font-medium transition">Dashboard</a>
                        <a href="{{ route('leaderboard') }}" class="hover:text-kart-cyan font-medium transition">Leaderboard</a>
                        
                        <!-- User Dropdown -->
                        <div class="relative ml-4">
                            <button id="userDropdownBtn" class="flex items-center space-x-2 hover:text-kart-cyan">
                                <div class="w-8 h-8 bg-kart-red rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                    <i class="fas fa-user-circle mr-2"></i> Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 bg-transparent border border-white rounded hover:bg-white hover:text-kart-blue transition font-medium">Login</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-kart-red rounded hover:bg-red-600 transition font-medium">Register</a>
                    @endauth
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden text-2xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <!-- Mobile Navigation -->
            <div id="mobileMenu" class="md:hidden mt-4 hidden">
                <div class="space-y-4">
                    <a href="{{ url('/') }}" class="block hover:text-kart-cyan">Home</a>
                    <a href="#packages" class="block hover:text-kart-cyan">Packages</a>
                    <a href="#about" class="block hover:text-kart-cyan">About</a>
                    <a href="#contact" class="block hover:text-kart-cyan">Contact</a>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="block hover:text-kart-cyan">Dashboard</a>
                        <a href="#" class="block hover:text-kart-cyan">Leaderboard</a>
                        <a href="{{ route('profile.edit') }}" class="block hover:text-kart-cyan">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left hover:text-kart-cyan">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block">Login</a>
                        <a href="{{ route('register') }}" class="block">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.pexels.com/photos/5640587/pexels-photo-5640587.jpeg" 
                 alt="Karting Race" class="w-full h-full object-cover">
            <div class="absolute inset-0 hero-gradient"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10 text-center text-white">
            <h1 class="text-5xl md:text-7xl font-heading mb-6 animate-pulse">FEEL THE <span class="text-kart-red">SPEED</span></h1>
            <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto font-light">Experience the ultimate adrenaline rush on our professional tracks. Book your kart now and race like a champion!</p>
            <div class="flex flex-col md:flex-row justify-center gap-6">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-10 py-4 bg-kart-red rounded text-xl font-bold hover:bg-red-600 transition transform hover:scale-105 shadow-2xl">
                        <i class="fas fa-bolt mr-2"></i> BOOK NOW
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-10 py-4 bg-kart-red rounded text-xl font-bold hover:bg-red-600 transition transform hover:scale-105 shadow-2xl">
                        <i class="fas fa-bolt mr-2"></i> BOOK NOW
                    </a>
                @endauth
                <a href="#packages" class="px-10 py-4 bg-transparent border-2 border-white rounded text-xl font-bold hover:bg-white hover:text-kart-blue transition">
                    VIEW PACKAGES
                </a>
            </div>
        </div>
        
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#packages" class="text-white text-3xl">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-kart-blue text-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="p-4">
                    <div class="text-4xl md:text-5xl font-bold mb-2">500+</div>
                    <div class="text-lg">Racers Daily</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl md:text-5xl font-bold mb-2">2KM</div>
                    <div class="text-lg">Track Length</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl md:text-5xl font-bold mb-2">50+</div>
                    <div class="text-lg">Karts Available</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl md:text-5xl font-bold mb-2">10+</div>
                    <div class="text-lg">Years Experience</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages -->
    <section id="packages" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-heading mb-4">RACE <span class="text-kart-red">PACKAGES</span></h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Choose the perfect racing experience for your skill level and adrenaline needs.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto">
                <!-- Beginner Package -->
                <div class="bg-kart-light rounded-2xl overflow-hidden shadow-xl card-hover">
                    <div class="p-2 bg-gradient-to-r from-green-400 to-blue-500"></div>
                    <div class="p-8 text-center">
                        <div class="w-20 h-20 mx-auto mb-6 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-graduate text-3xl text-green-600"></i>
                        </div>
                        <h3 class="text-3xl font-bold mb-2">BEGINNER</h3>
                        <div class="text-4xl font-bold mb-6">$20<span class="text-lg text-gray-500">/session</span></div>
                        
                        <ul class="mb-8 space-y-3 text-left">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>15-minute track session</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Safety briefing & training</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Beginner-friendly karts</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Helmet & safety gear included</span>
                            </li>
                        </ul>
                        
                        @auth
                            <a href="{{ route('dashboard') }}" class="block w-full py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-bold">
                                BOOK THIS PACKAGE
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-bold">
                                BOOK THIS PACKAGE
                            </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Advanced Package -->
                <div class="bg-kart-light rounded-2xl overflow-hidden shadow-2xl card-hover transform scale-105 relative">
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-kart-red text-white px-6 py-2 rounded-full font-bold">
                        MOST POPULAR
                    </div>
                    <div class="p-2 bg-gradient-to-r from-yellow-400 to-orange-500"></div>
                    <div class="p-8 text-center">
                        <div class="w-20 h-20 mx-auto mb-6 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-tachometer-alt text-3xl text-yellow-600"></i>
                        </div>
                        <h3 class="text-3xl font-bold mb-2">ADVANCED</h3>
                        <div class="text-4xl font-bold mb-6">$40<span class="text-lg text-gray-500">/session</span></div>
                        
                        <ul class="mb-8 space-y-3 text-left">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>30-minute track session</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Faster racing karts</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Lap time tracking</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Professional coaching tips</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Certificate of completion</span>
                            </li>
                        </ul>
                        
                        @auth
                            <a href="{{ route('dashboard') }}" class="block w-full py-3 bg-kart-red text-white rounded-lg hover:bg-red-600 transition font-bold">
                                BOOK THIS PACKAGE
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full py-3 bg-kart-red text-white rounded-lg hover:bg-red-600 transition font-bold">
                                BOOK THIS PACKAGE
                            </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Pro Racer Package -->
                <div class="bg-kart-light rounded-2xl overflow-hidden shadow-xl card-hover">
                    <div class="p-2 bg-gradient-to-r from-red-500 to-purple-600"></div>
                    <div class="p-8 text-center">
                        <div class="w-20 h-20 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-crown text-3xl text-red-600"></i>
                        </div>
                        <h3 class="text-3xl font-bold mb-2">PRO RACER</h3>
                        <div class="text-4xl font-bold mb-6">$60<span class="text-lg text-gray-500">/session</span></div>
                        
                        <ul class="mb-8 space-y-3 text-left">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Full 60-minute session</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>High-performance racing karts</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Advanced telemetry data</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Personalized coaching session</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                <span>Priority track access</span>
                            </li>
                        </ul>
                        
                        @auth
                            <a href="{{ route('dashboard') }}" class="block w-full py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-bold">
                                BOOK THIS PACKAGE
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-bold">
                                BOOK THIS PACKAGE
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-heading mb-4">WHY <span class="text-kart-red">CHOOSE US</span></h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">We provide the ultimate karting experience with safety, excitement, and professional service.</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <img src="https://images.pexels.com/photos/5640504/pexels-photo-5640504.jpeg" 
                         alt="Karting Track" class="rounded-2xl shadow-2xl">
                </div>
                <div>
                    <h3 class="text-3xl font-bold mb-6">State-of-the-Art Racing Facility</h3>
                    <p class="text-lg mb-6">Our track is designed by professional race engineers to provide the perfect balance of challenge and safety. With multiple configurations available, every visit offers a new racing experience.</p>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-kart-red text-white p-2 rounded-lg mr-4">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg">Safety First</h4>
                                <p>All equipment meets international safety standards with regular maintenance checks.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-kart-red text-white p-2 rounded-lg mr-4">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg">High-Speed Thrills</h4>
                                <p>Our karts are tuned for maximum performance while maintaining optimal safety margins.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover">
                    <div class="w-20 h-20 mx-auto mb-6 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-3xl text-kart-blue"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4">Expert Team</h4>
                    <p>Our staff includes professional racers and certified instructors who are passionate about karting.</p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover">
                    <div class="w-20 h-20 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-trophy text-3xl text-kart-red"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4">Race Events</h4>
                    <p>Regular tournaments and corporate events that bring together racing enthusiasts from all over.</p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover">
                    <div class="w-20 h-20 mx-auto mb-6 bg-cyan-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-star text-3xl text-cyan-600"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4">5-Star Reviews</h4>
                    <p>Consistently rated as one of the best karting experiences in the region by our customers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-kart-blue text-white pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-10">
                <div>
                    <div class="flex items-center space-x-2 mb-6">
                        <div class="w-10 h-10 bg-kart-red rounded-full flex items-center justify-center">
                            <i class="fas fa-flag-checkered text-white"></i>
                        </div>
                        <a href="{{ url('/') }}" class="text-3xl font-heading">KART<span class="text-kart-red">CENTER</span></a>
                    </div>
                    <p class="mb-6">Providing the ultimate karting experience since 2012. Safety, speed, and excitement guaranteed.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-kart-red transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-kart-red transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-kart-red transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-kart-red transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ url('/') }}" class="hover:text-kart-cyan transition">Home</a></li>
                        <li><a href="#packages" class="hover:text-kart-cyan transition">Packages</a></li>
                        <li><a href="#about" class="hover:text-kart-cyan transition">About Us</a></li>
                        <li><a href="#contact" class="hover:text-kart-cyan transition">Contact</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="hover:text-kart-cyan transition">Dashboard</a></li>
                            <li><a href="#" class="hover:text-kart-cyan transition">Leaderboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-kart-cyan transition">Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-kart-cyan transition">Register</a></li>
                        @endauth
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-6">Contact Info</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-kart-red mr-3 mt-1"></i>
                            <span>123 Speedway Ave, Racing City, RC 10001</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone text-kart-red mr-3"></i>
                            <span>(555) 123-4567</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-kart-red mr-3"></i>
                            <span>info@kartcenter.com</span>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-xl font-bold mb-6">Opening Hours</h4>
                    <ul class="space-y-2">
                        <li class="flex justify-between">
                            <span>Mon - Fri</span>
                            <span>10AM - 10PM</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Saturday</span>
                            <span>9AM - 11PM</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Sunday</span>
                            <span>9AM - 9PM</span>
                        </li>
                    </ul>
                    <div class="mt-8 p-4 bg-gray-800 rounded-lg">
                        <p class="font-bold mb-2">Ready to Race?</p>
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-block w-full py-2 bg-kart-red text-center rounded hover:bg-red-600 transition">
                                Book Your Session
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-block w-full py-2 bg-kart-red text-center rounded hover:bg-red-600 transition">
                                Book Your Session
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} KartCenter. All rights reserved. | Designed with <i class="fas fa-heart text-kart-red"></i> for racing enthusiasts</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        });

        // User dropdown toggle
        const userDropdownBtn = document.getElementById('userDropdownBtn');
        const userDropdown = document.getElementById('userDropdown');
        
        if (userDropdownBtn && userDropdown) {
            userDropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                userDropdown.classList.add('hidden');
            });

            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    document.getElementById('mobileMenu').classList.add('hidden');
                }
            });
        });
    </script>

</body>
</html>