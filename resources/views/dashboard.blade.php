<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KartCenter</title>
    
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
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            animation: modalFadeIn 0.3s ease-out;
        }
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="font-body text-gray-800 bg-kart-light">

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-kart-blue text-white shadow-xl">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-kart-red rounded-full flex items-center justify-center">
                        <i class="fas fa-flag-checkered text-white"></i>
                    </div>
                    <a href="{{ url('/') }}" class="text-3xl font-heading tracking-wide">KART<span class="text-kart-red">CENTER</span></a>
                </div>
                
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ url('/') }}" class="hover:text-kart-cyan font-medium transition">Home</a>
                    <a href="{{ route('leaderboard') }}" class="hover:text-kart-cyan font-medium transition">Leaderboard</a>
                    
                    <!-- User Dropdown -->
                    <div class="relative">
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
                    <a href="{{ route('profile.edit') }}" class="block hover:text-kart-cyan">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left hover:text-kart-cyan">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Success Message -->
    @if(session('success'))
        <div id="successAlert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                    <button onclick="closeAlert()" class="text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="min-h-screen py-12">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-heading mb-4">BOOK YOUR <span class="text-kart-red">RACE</span></h1>
                <p class="text-xl text-gray-600">Complete the form below to reserve your spot on the track</p>
            </div>

            <!-- Booking Form & Summary -->
            <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Left Column: Booking Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl font-bold mb-6 text-kart-blue border-b pb-3">
                            <i class="fas fa-calendar-alt mr-2"></i> Booking Details
                        </h2>
                        
                        <form method="POST" action="{{ route('reservations.store') }}" id="bookingForm">
                            @csrf
                            
                            <!-- Package Selection -->
                            <div class="mb-8">
                                <h3 class="text-lg font-bold mb-4">1. Select Your Package</h3>
                                <div class="grid md:grid-cols-3 gap-4">
                                    <div class="relative">
                                        <input type="radio" id="package_beginner" name="package" value="beginner" class="hidden peer" checked>
                                        <label for="package_beginner" class="block p-4 border-2 border-gray-200 rounded-lg peer-checked:border-kart-red peer-checked:bg-red-50 cursor-pointer transition">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-user-graduate text-green-600"></i>
                                                </div>
                                                <div>
                                                    <div class="font-bold">BEGINNER</div>
                                                    <div class="text-lg font-bold text-kart-red">$20</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="relative">
                                        <input type="radio" id="package_advanced" name="package" value="advanced" class="hidden peer">
                                        <label for="package_advanced" class="block p-4 border-2 border-gray-200 rounded-lg peer-checked:border-kart-red peer-checked:bg-red-50 cursor-pointer transition">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-tachometer-alt text-yellow-600"></i>
                                                </div>
                                                <div>
                                                    <div class="font-bold">ADVANCED</div>
                                                    <div class="text-lg font-bold text-kart-red">$40</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="relative">
                                        <input type="radio" id="package_pro" name="package" value="pro" class="hidden peer">
                                        <label for="package_pro" class="block p-4 border-2 border-gray-200 rounded-lg peer-checked:border-kart-red peer-checked:bg-red-50 cursor-pointer transition">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-crown text-red-600"></i>
                                                </div>
                                                <div>
                                                    <div class="font-bold">PRO RACER</div>
                                                    <div class="text-lg font-bold text-kart-red">$60</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Date & Time -->
                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label for="date" class="block text-sm font-bold mb-2">
                                        <i class="far fa-calendar mr-1"></i> Date
                                    </label>
                                    <input type="date" name="date" id="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-kart-red focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label for="time_slot" class="block text-sm font-bold mb-2">
                                        <i class="far fa-clock mr-1"></i> Time Slot
                                    </label>
                                    <select name="time_slot" id="time_slot" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-kart-red focus:border-transparent" required>
                                        <option value="">Select time</option>
                                        <option value="09:00">09:00 AM</option>
                                        <option value="10:30">10:30 AM</option>
                                        <option value="12:00">12:00 PM</option>
                                        <option value="14:00">02:00 PM</option>
                                        <option value="16:00">04:00 PM</option>
                                        <option value="18:00">06:00 PM</option>
                                        <option value="20:00">08:00 PM</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Number of Participants -->
                            <div class="mb-8">
                                <label for="participants" class="block text-sm font-bold mb-2">
                                    <i class="fas fa-users mr-1"></i> Number of Karts
                                </label>
                                <div class="flex items-center space-x-4">
                                    <button type="button" id="decrement" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="participants" id="participants" value="1" min="1" max="10" class="w-20 text-center px-4 py-2 border border-gray-300 rounded-lg">
                                    <button type="button" id="increment" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <span class="text-gray-600">(Max 10 per session)</span>
                                </div>
                            </div>
                            
                            <!-- Additional Options -->
                            <div class="mb-8">
                                <h3 class="text-lg font-bold mb-4">Additional Options</h3>
                                <div class="space-y-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="helmet" id="helmet" value="1" class="w-5 h-5 text-kart-red rounded focus:ring-kart-red">
                                        <span class="ml-3">Premium Helmet Upgrade ($5)</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="insurance" id="insurance" value="1" class="w-5 h-5 text-kart-red rounded focus:ring-kart-red">
                                        <span class="ml-3">Accident Insurance ($10)</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="video" id="video" value="1" class="w-5 h-5 text-kart-red rounded focus:ring-kart-red">
                                        <span class="ml-3">Onboard Video Recording ($15)</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Special Instructions -->
                            <div class="mb-8">
                                <label for="instructions" class="block text-sm font-bold mb-2">
                                    <i class="fas fa-edit mr-1"></i> Special Instructions
                                </label>
                                <textarea name="instructions" id="instructions" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-kart-red focus:border-transparent" placeholder="Any special requests or instructions..."></textarea>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Right Column: Booking Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-8 sticky top-24">
                        <h2 class="text-2xl font-bold mb-6 text-kart-blue border-b pb-3">
                            <i class="fas fa-receipt mr-2"></i> Booking Summary
                        </h2>
                        
                        <div id="summaryContent" class="mb-8">
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Package:</span>
                                    <span id="summaryPackage" class="font-bold">Beginner</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Date & Time:</span>
                                    <span id="summaryDateTime" class="font-bold">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Karts:</span>
                                    <span id="summaryKarts" class="font-bold">1</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Duration:</span>
                                    <span id="summaryDuration" class="font-bold">15 minutes</span>
                                </div>
                                
                                <div id="summaryAddons" class="pt-4 border-t">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Premium Helmet:</span>
                                        <span id="addonHelmet" class="font-bold">$0</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Insurance:</span>
                                        <span id="addonInsurance" class="font-bold">$0</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Video Recording:</span>
                                        <span id="addonVideo" class="font-bold">$0</span>
                                    </div>
                                </div>
                                
                                <div class="pt-4 border-t">
                                    <div class="flex justify-between text-lg font-bold">
                                        <span>TOTAL:</span>
                                        <span id="summaryTotal" class="text-kart-red">$20</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Book Now Button -->
                        <button type="submit" form="bookingForm" class="w-full py-4 bg-kart-red text-white rounded-lg hover:bg-red-600 transition font-bold text-lg shadow-lg transform hover:scale-[1.02]">
                            <i class="fas fa-flag-checkered mr-2"></i> CONFIRM BOOKING
                        </button>
                        
                        <p class="text-sm text-gray-500 mt-4 text-center">
                            <i class="fas fa-lock mr-1"></i> Secure booking. Cancel up to 24 hours before.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Recent Bookings Section -->
            <div class="mt-16 max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold mb-8 text-kart-blue">
                    <i class="fas fa-history mr-2"></i> Your Bookings
                </h2>
                
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    @if($reservations->count() > 0)
                        <div class="space-y-4">
                            @foreach($reservations as $reservation)
                            <div class="border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition card-hover">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-bold text-lg">{{ ucfirst($reservation->package) }} Package</h4>
                                        <p class="text-gray-600">
                                            <i class="far fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y') }}
                                            <i class="far fa-clock ml-3 mr-1"></i> {{ $reservation->time_slot }}
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 
                                        @if($reservation->package == 'beginner') bg-green-100 text-green-800
                                        @elseif($reservation->package == 'advanced') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif
                                         rounded-full text-sm font-medium">
                                        {{ strtoupper($reservation->package) }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-3">
                                    <div class="text-sm">
                                        <p class="text-gray-500">Karts:</p>
                                        <p class="font-medium">{{ $reservation->participants }}</p>
                                    </div>
                                    <div class="text-sm">
                                        <p class="text-gray-500">Total:</p>
                                        <p class="font-bold text-kart-red">${{ number_format($reservation->total_price, 2) }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @if($reservation->helmet)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">Helmet Upgrade</span>
                                    @endif
                                    @if($reservation->insurance)
                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded">Insurance</span>
                                    @endif
                                    @if($reservation->video)
                                        <span class="px-2 py-1 bg-pink-100 text-pink-800 text-xs rounded">Video Recording</span>
                                    @endif
                                </div>
                                
                                @if($reservation->instructions)
                                <div class="mb-3 p-3 bg-gray-50 rounded">
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-sticky-note mr-1"></i> 
                                        <span class="font-medium">Instructions:</span> {{ $reservation->instructions }}
                                    </p>
                                </div>
                                @endif
                                
                                <div class="flex justify-between items-center text-sm text-gray-500">
                                    <span>
                                        <i class="far fa-clock mr-1"></i> 
                                        Booked on {{ $reservation->created_at->format('M d, Y H:i') }}
                                    </span>
                                    <form method="POST" action="{{ route('reservations.destroy', $reservation->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" 
                                                onclick="return confirm('Are you sure you want to cancel this booking?')">
                                            <i class="fas fa-trash mr-1"></i> Cancel Booking
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-flag-checkered text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">No Bookings Yet</h3>
                            <p class="text-gray-600">Make your first booking to get started!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-kart-blue text-white py-10">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} KartCenter. All rights reserved. | Designed with <i class="fas fa-heart text-kart-red"></i> for racing enthusiasts</p>
            </div>
        </div>
    </footer>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal-overlay">
        <div class="modal-content bg-white rounded-2xl p-8 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check text-4xl text-green-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-2 text-kart-blue">Booking Confirmed!</h3>
                <p class="text-gray-600 mb-4">Your reservation has been successfully booked.</p>
                
                <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left">
                    <p class="mb-2"><span class="font-semibold">Package:</span> <span id="modalPackage"></span></p>
                    <p class="mb-2"><span class="font-semibold">Date & Time:</span> <span id="modalDateTime"></span></p>
                    <p class="mb-2"><span class="font-semibold">Karts:</span> <span id="modalKarts"></span></p>
                    <p class="mb-2"><span class="font-semibold">Total Amount:</span> <span id="modalTotal" class="text-kart-red font-bold"></span></p>
                </div>
                
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 text-left">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-envelope mr-2"></i>
                        A confirmation email has been sent to <span class="font-bold">{{ Auth::user()->email }}</span>
                    </p>
                </div>
                
                <button onclick="closeModal()" class="w-full py-3 bg-kart-red text-white rounded-lg hover:bg-red-600 transition font-bold">
                    <i class="fas fa-thumbs-up mr-2"></i> Awesome, Thanks!
                </button>
                
                <p class="text-sm text-gray-500 mt-4">
                    <i class="fas fa-info-circle mr-1"></i>
                    Please arrive 30 minutes before your scheduled time.
                </p>
            </div>
        </div>
    </div>

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

            document.addEventListener('click', function() {
                userDropdown.classList.add('hidden');
            });

            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Participants counter
        document.getElementById('increment').addEventListener('click', function() {
            const input = document.getElementById('participants');
            if (parseInt(input.value) < 10) {
                input.value = parseInt(input.value) + 1;
                updateSummary();
            }
        });

        document.getElementById('decrement').addEventListener('click', function() {
            const input = document.getElementById('participants');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateSummary();
            }
        });

        // Package prices
        const packagePrices = {
            beginner: 20,
            advanced: 40,
            pro: 60
        };

        const packageDurations = {
            beginner: '15 minutes',
            advanced: '30 minutes',
            pro: '60 minutes'
        };

        // Addon prices
        const addonPrices = {
            helmet: 5,
            insurance: 10,
            video: 15
        };

        // Update summary when form changes
        function updateSummary() {
            // Get selected package
            const selectedPackage = document.querySelector('input[name="package"]:checked').value;
            const packagePrice = packagePrices[selectedPackage];
            
            // Get date and time
            const date = document.getElementById('date').value;
            const timeSlot = document.getElementById('time_slot').value;
            const dateTime = date && timeSlot ? `${date} at ${timeSlot}` : '-';
            
            // Get number of karts
            const karts = document.getElementById('participants').value;
            
            // Get addons
            const helmet = document.getElementById('helmet').checked;
            const insurance = document.getElementById('insurance').checked;
            const video = document.getElementById('video').checked;
            
            // Calculate totals
            let total = packagePrice * karts;
            let helmetCost = helmet ? addonPrices.helmet * karts : 0;
            let insuranceCost = insurance ? addonPrices.insurance * karts : 0;
            let videoCost = video ? addonPrices.video * karts : 0;
            
            total += helmetCost + insuranceCost + videoCost;
            
            // Update summary display
            document.getElementById('summaryPackage').textContent = selectedPackage.charAt(0).toUpperCase() + selectedPackage.slice(1);
            document.getElementById('summaryDateTime').textContent = dateTime;
            document.getElementById('summaryKarts').textContent = karts;
            document.getElementById('summaryDuration').textContent = packageDurations[selectedPackage];
            document.getElementById('addonHelmet').textContent = `$${helmetCost}`;
            document.getElementById('addonInsurance').textContent = `$${insuranceCost}`;
            document.getElementById('addonVideo').textContent = `$${videoCost}`;
            document.getElementById('summaryTotal').textContent = `$${total}`;
        }

        // Initialize event listeners for form changes
        document.querySelectorAll('input[name="package"]').forEach(radio => {
            radio.addEventListener('change', updateSummary);
        });

        document.getElementById('date').addEventListener('change', updateSummary);
        document.getElementById('time_slot').addEventListener('change', updateSummary);
        document.getElementById('participants').addEventListener('input', updateSummary);

        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateSummary);
        });

        // Initial summary update
        updateSummary();

        // Form submit handler
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            const date = document.getElementById('date').value;
            const timeSlot = document.getElementById('time_slot').value;
            
            if (!date || !timeSlot) {
                e.preventDefault();
                alert('Please select a date and time slot');
                return;
            }
            
            // Show loading state
            const submitBtn = document.querySelector('button[form="bookingForm"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            submitBtn.disabled = true;
            
            // Save form data to localStorage for modal
            const formData = {
                package: document.querySelector('input[name="package"]:checked').value,
                date: date,
                timeSlot: timeSlot,
                participants: document.getElementById('participants').value,
                total: document.getElementById('summaryTotal').textContent
            };
            localStorage.setItem('lastBooking', JSON.stringify(formData));
        });

        // Show success message and modal if booking was successful
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                const lastBooking = JSON.parse(localStorage.getItem('lastBooking'));
                if (lastBooking) {
                    // Populate modal with data
                    document.getElementById('modalPackage').textContent = lastBooking.package.charAt(0).toUpperCase() + lastBooking.package.slice(1);
                    document.getElementById('modalDateTime').textContent = lastBooking.date && lastBooking.timeSlot ? 
                        `${lastBooking.date} at ${lastBooking.timeSlot}` : '-';
                    document.getElementById('modalKarts').textContent = lastBooking.participants;
                    document.getElementById('modalTotal').textContent = lastBooking.total;
                    
                    // Show modal
                    document.getElementById('confirmationModal').style.display = 'flex';
                    
                    // Clear localStorage
                    localStorage.removeItem('lastBooking');
                }
            @endif
        });

        // Alert close function
        function closeAlert() {
            document.getElementById('successAlert').style.display = 'none';
        }

        // Modal functions
        function closeModal() {
            document.getElementById('confirmationModal').style.display = 'none';
        }

        // Close modal when clicking outside or pressing Escape
        document.getElementById('confirmationModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>

</body>
</html>