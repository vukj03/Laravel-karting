<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - KartCenter</title>
    
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
        .podium-1 {
            height: 180px;
            background: linear-gradient(135deg, #FFD700 0%, #FFEC8B 100%);
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.3);
        }
        .podium-2 {
            height: 140px;
            background: linear-gradient(135deg, #C0C0C0 0%, #E0E0E0 100%);
            box-shadow: 0 8px 25px rgba(192, 192, 192, 0.3);
        }
        .podium-3 {
            height: 120px;
            background: linear-gradient(135deg, #CD7F32 0%, #E6B17A 100%);
            box-shadow: 0 6px 20px rgba(205, 127, 50, 0.3);
        }
        .rank-badge {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 1.25rem;
            margin: 0 auto 10px auto;
        }
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
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
                    <a href="{{ route('dashboard') }}" class="hover:text-kart-cyan font-medium transition">Dashboard</a>
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
                    <a href="{{ route('dashboard') }}" class="block hover:text-kart-cyan">Dashboard</a>
                    <a href="{{ route('leaderboard') }}" class="block hover:text-kart-cyan">Leaderboard</a>
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

    <!-- Main Content -->
    <div class="min-h-screen py-12">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-heading mb-4"><span class="text-kart-red">LEADERBOARD</span></h1>
                <p class="text-xl text-gray-600">Top racers and their best lap times</p>
            </div>

            <!-- Podium Section -->
            <div class="max-w-4xl mx-auto mb-16">
                <h2 class="text-2xl font-bold mb-8 text-center text-kart-blue">
                    <i class="fas fa-trophy mr-2"></i> CHAMPIONSHIP PODIUM
                </h2>
                
                <div class="flex justify-center items-end space-x-6 md:space-x-12">
                    <!-- 2nd Place -->
                    <div class="text-center flex-1">
                        <div class="podium-2 rounded-t-lg flex flex-col justify-end items-center relative overflow-hidden">
                            <div class="absolute top-4 left-1/2 transform -translate-x-1/2">
                                <div class="rank-badge bg-gray-200 text-gray-800">2</div>
                            </div>
                            <div class="mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center mx-auto mb-2 border-4 border-white shadow-lg">
                                    <i class="fas fa-user text-2xl text-white"></i>
                                </div>
                                <h3 class="font-bold text-lg" id="podiumName2">Sarah Zoom</h3>
                                <p class="text-kart-red font-bold text-xl" id="podiumTime2">1:46.15</p>
                                <p class="text-sm text-gray-600" id="podiumPoints2">950 pts</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 1st Place -->
                    <div class="text-center flex-1">
                        <div class="podium-1 rounded-t-lg flex flex-col justify-end items-center relative overflow-hidden floating">
                            <div class="absolute top-6 left-1/2 transform -translate-x-1/2">
                                <div class="rank-badge bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-crown"></i>
                                </div>
                            </div>
                            <div class="mb-8">
                                <div class="w-20 h-20 bg-gradient-to-br from-yellow-300 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-3 border-4 border-white shadow-lg">
                                    <i class="fas fa-trophy text-3xl text-white"></i>
                                </div>
                                <h3 class="font-bold text-xl" id="podiumName1">Max Speedster</h3>
                                <p class="text-kart-red font-bold text-2xl" id="podiumTime1">1:45.32</p>
                                <p class="text-sm text-gray-600" id="podiumPoints1">985 pts</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 3rd Place -->
                    <div class="text-center flex-1">
                        <div class="podium-3 rounded-t-lg flex flex-col justify-end items-center relative overflow-hidden">
                            <div class="absolute top-4 left-1/2 transform -translate-x-1/2">
                                <div class="rank-badge bg-orange-100 text-orange-800">3</div>
                            </div>
                            <div class="mb-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-orange-300 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-2 border-4 border-white shadow-lg">
                                    <i class="fas fa-user text-2xl text-white"></i>
                                </div>
                                <h3 class="font-bold text-lg" id="podiumName3">Carlos Racer</h3>
                                <p class="text-kart-red font-bold text-xl" id="podiumTime3">1:47.89</p>
                                <p class="text-sm text-gray-600" id="podiumPoints3">920 pts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leaderboard Table -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <!-- Table Header -->
                    <div class="bg-kart-blue text-white px-6 py-4">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold">
                                <i class="fas fa-list-ol mr-2"></i> Season Rankings
                            </h2>
                            <div class="flex items-center space-x-4">
                                <select id="timeFilter" class="bg-white text-kart-blue px-3 py-1 rounded">
                                    <option value="all">All Time</option>
                                    <option value="month">This Month</option>
                                    <option value="week">This Week</option>
                                </select>
                                <button onclick="refreshLeaderboard()" class="bg-kart-red hover:bg-red-600 px-4 py-2 rounded transition">
                                    <i class="fas fa-sync-alt mr-1"></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-kart-blue uppercase tracking-wider">Rank</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-kart-blue uppercase tracking-wider">Racer</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-kart-blue uppercase tracking-wider">Best Lap Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-kart-blue uppercase tracking-wider">Kart #</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-kart-blue uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-kart-blue uppercase tracking-wider">Points</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="leaderboardBody">
                                <!-- JavaScript će popuniti ovde -->
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Your Position Card -->
                <div class="mt-8 bg-gradient-to-r from-kart-blue to-kart-red rounded-2xl shadow-xl p-6 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Your Position</h3>
                            <p class="mb-1">You're currently ranked <span id="userRank" class="font-bold text-2xl">#15</span></p>
                            <p class="text-sm opacity-90">Best lap: <span id="userBestLap">2:15.43</span> • Total races: <span id="userTotalRaces">12</span></p>
                        </div>
                        <div class="text-right">
                            <div class="text-4xl font-bold"><span id="userPoints">650</span> pts</div>
                            <p class="text-sm opacity-90"><span id="pointsToNext">25</span> pts to next rank</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-kart-blue text-white py-10">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} KartCenter. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Lista random imena za leaderboard
        const firstNames = ["Max", "Alex", "Chris", "Jordan", "Taylor", "Casey", "Morgan", "Riley", "Dakota", "Skyler"];
        const lastNames = ["Speedster", "Lightning", "Racer", "Turbo", "Flash", "Zoom", "Fast", "Swift", "Dash", "Speed"];
        const trackNames = ["Velocity", "Thunder", "Nitro", "Blaze", "Vortex", "Cyclone", "Typhoon", "Hurricane", "Tornado", "Storm"];
        
        // Generiši random imena
        function generateRandomName() {
            const firstName = firstNames[Math.floor(Math.random() * firstNames.length)];
            const lastName = lastNames[Math.floor(Math.random() * lastNames.length)];
            return `${firstName} ${lastName}`;
        }
        
        // Generiši random vreme
        function generateRandomTime() {
            const minutes = Math.floor(Math.random() * 2) + 1;
            const seconds = Math.floor(Math.random() * 60).toString().padStart(2, '0');
            const milliseconds = Math.floor(Math.random() * 100).toString().padStart(2, '0');
            return `${minutes}:${seconds}.${milliseconds}`;
        }
        
        // Generiši random podatke za leaderboard
        function generateLeaderboardData(count = 20) {
            const data = [];
            for (let i = 1; i <= count; i++) {
                data.push({
                    id: i,
                    name: generateRandomName(),
                    lapTime: generateRandomTime(),
                    kart: Math.floor(Math.random() * 50) + 1,
                    date: new Date(Date.now() - Math.floor(Math.random() * 30) * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
                    points: 1000 - (i * 25) + Math.floor(Math.random() * 50),
                    level: i <= 3 ? 'pro' : i <= 10 ? 'advanced' : 'beginner'
                });
            }
            // Sortiraj po vremenu (niže vreme = bolje)
            return data.sort((a, b) => {
                const timeA = a.lapTime.split(':').map(Number);
                const timeB = b.lapTime.split(':').map(Number);
                const totalA = timeA[0] * 60 + timeA[1];
                const totalB = timeB[0] * 60 + timeB[1];
                return totalA - totalB;
            });
        }

        // Leaderboard data
        let leaderboardData = generateLeaderboardData(20);

        // Function to render podium
        function renderPodium() {
            const topThree = leaderboardData.slice(0, 3);
            
            // 1st place
            document.getElementById('podiumName1').textContent = topThree[0]?.name || "Max Speedster";
            document.getElementById('podiumTime1').textContent = topThree[0]?.lapTime || "1:45.32";
            document.getElementById('podiumPoints1').textContent = `${topThree[0]?.points || 985} pts`;
            
            // 2nd place
            document.getElementById('podiumName2').textContent = topThree[1]?.name || "Anna Lightning";
            document.getElementById('podiumTime2').textContent = topThree[1]?.lapTime || "1:46.15";
            document.getElementById('podiumPoints2').textContent = `${topThree[1]?.points || 950} pts`;
            
            // 3rd place
            document.getElementById('podiumName3').textContent = topThree[2]?.name || "Carlos Racer";
            document.getElementById('podiumTime3').textContent = topThree[2]?.lapTime || "1:47.89";
            document.getElementById('podiumPoints3').textContent = `${topThree[2]?.points || 920} pts`;
        }

        // Function to render leaderboard table
        function renderLeaderboardTable(filter = 'all') {
            let data = leaderboardData;
            
            // Filter data (u pravoj aplikaciji bi bilo server-side)
            if (filter === 'month') {
                const oneMonthAgo = new Date();
                oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
                data = data.filter(racer => new Date(racer.date) >= oneMonthAgo);
            } else if (filter === 'week') {
                const oneWeekAgo = new Date();
                oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
                data = data.filter(racer => new Date(racer.date) >= oneWeekAgo);
            }
            
            const tbody = document.getElementById('leaderboardBody');
            tbody.innerHTML = '';
            
            // Preskoči prva 3 jer su na podiumu
            const tableData = data.slice(3);
            
            tableData.forEach((racer, index) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50 transition';
                
                // Rank (počinje od 4)
                const rank = index + 4;
                
                // Level badge color
                const levelColors = {
                    'beginner': 'bg-green-100 text-green-800',
                    'advanced': 'bg-yellow-100 text-yellow-800',
                    'pro': 'bg-red-100 text-red-800'
                };
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="w-8 h-8 ${rank <= 10 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'} rounded-full flex items-center justify-center font-bold">
                                ${rank}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 ${levelColors[racer.level]} rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <div class="font-bold">${racer.name}</div>
                                <div class="text-sm text-gray-500">${racer.level.charAt(0).toUpperCase() + racer.level.slice(1)} Level</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-bold text-xl ${rank <= 10 ? 'text-kart-red' : 'text-kart-blue'}">
                            ${racer.lapTime}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                            Kart #${racer.kart}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                        ${new Date(racer.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-bold">${racer.points}</span>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
            
            // Update user stats (simulacija)
            updateUserStats();
        }

        // Update user statistics
        function updateUserStats() {
            // Random user rank između 4 i 20
            const userRank = Math.floor(Math.random() * 17) + 4;
            const userBestLap = generateRandomTime();
            const userTotalRaces = Math.floor(Math.random() * 20) + 5;
            const userPoints = 1000 - (userRank * 25) + Math.floor(Math.random() * 50);
            const pointsToNext = Math.floor(Math.random() * 50) + 10;
            
            document.getElementById('userRank').textContent = `#${userRank}`;
            document.getElementById('userBestLap').textContent = userBestLap;
            document.getElementById('userTotalRaces').textContent = userTotalRaces;
            document.getElementById('userPoints').textContent = userPoints;
            document.getElementById('pointsToNext').textContent = pointsToNext;
        }

        // Filter change handler
        document.getElementById('timeFilter').addEventListener('change', function(e) {
            renderLeaderboardTable(e.target.value);
        });

        // Refresh button handler
        function refreshLeaderboard() {
            const button = document.querySelector('button[onclick="refreshLeaderboard()"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Refreshing...';
            button.disabled = true;
            
            setTimeout(() => {
                // Generiši nove random podatke
                leaderboardData = generateLeaderboardData(20);
                
                // Ponovo renderuj
                renderPodium();
                renderLeaderboardTable(document.getElementById('timeFilter').value);
                
                button.innerHTML = originalText;
                button.disabled = false;
                
                // Show notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-20 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                notification.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Leaderboard updated!';
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }, 1000);
        }

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

        // Initial render
        renderPodium();
        renderLeaderboardTable();
    </script>

</body>
</html>