<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Telkom University Parking</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .glow-bg {
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(147,51,234,0.3) 0%, rgba(67,24,108,0.1) 50%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            z-index: 0;
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .hero-text {
            font-size: 5rem;
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: -0.02em;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .welcome-text {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .description-text {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease-out 0.2s forwards;
        }
        .cta-section {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease-out 0.4s forwards;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .weather-card {
            backdrop-filter: blur(12px);
            background: linear-gradient(145deg, rgba(67,24,108,0.4) 0%, rgba(147,51,234,0.2) 100%);
            border: 1px solid rgba(255,255,255,0.1);
            opacity: 0;
            transform: translateX(20px);
            animation: fadeInRight 0.8s ease-out 0.6s forwards;
        }
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .nav-logo {
            width: 40px;
            height: 40px;
            padding: 6px;
            background: #fff;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-black text-white overflow-x-hidden">
    <div class="min-h-screen relative">
        <!-- Glowing Background -->
        <div class="glow-bg top-[-400px] right-[-200px] opacity-40"></div>
        <div class="glow-bg bottom-[-400px] left-[-200px] opacity-30"></div>

        <!-- Navigation -->
        <nav class="border-b border-gray-800 bg-black relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('dashboard') }}" class="flex-shrink-0">
                            <img src="{{ asset('logo.png') }}" alt="Logo" class="nav-logo">
                        </a>
                        <div class="hidden md:flex space-x-8">
                            <a href="{{ route('dashboard') }}" class="text-white font-medium">Dashboard</a>
                            <a href="{{ route('vehicles.manage') }}" class="text-gray-300 hover:text-white">Manage</a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button onclick="toggleProfileMenu()" class="p-2 rounded-full hover:bg-gray-800">
                                <div class="h-8 w-8 bg-gray-700 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            </button>
                            <!-- Profile Dropdown -->
                            <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-gray-900 ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <div class="px-4 py-2 text-sm text-gray-300">
                                        <p class="font-medium">{{ auth()->user()->name }}</p>
                                        <p class="text-gray-400">{{ auth()->user()->email }}</p>
                                    </div>
                                    <hr class="border-gray-800">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800">
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex min-h-[calc(100vh-4rem)] items-center">
                <div class="w-full">
                    <div class="welcome-text flex items-center space-x-2 mb-4">
                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                        <p class="text-purple-400 text-lg">Welcome, {{ auth()->user()->name }}</p>
                    </div>
                    
                    <div class="flex items-start justify-between">
                        <div class="max-w-2xl">
                            <h1 class="hero-text mb-6">
                                Park Smartly<br>
                                And Integrated
                            </h1>
                            
                            <p class="text-gray-400 text-xl mb-12 max-w-2xl description-text">
                                Say goodbye to parking hassles and hello to easy management with our innovative parking system.
                            </p>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                <!-- Motorcycle Stats -->
                                <div class="weather-card rounded-2xl p-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-semibold text-white">Motorcycles</h3>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="text-3xl font-bold text-white">{{ $totalMotorcycles }}</div>
                                    <p class="text-gray-400 mt-1">Registered motorcycles</p>
                                </div>

                                <!-- Car Stats -->
                                <div class="weather-card rounded-2xl p-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-semibold text-white">Cars</h3>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="text-3xl font-bold text-white">{{ $totalCars }}</div>
                                    <p class="text-gray-400 mt-1">Registered cars</p>
                                </div>

                                <!-- Latest Vehicle -->
                                <div class="weather-card rounded-2xl p-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-semibold text-white">Latest Entry</h3>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    @if($latestVehicle)
                                        <div class="text-white">
                                            <p class="font-semibold">{{ $latestVehicle->license_plate }}</p>
                                            <p class="text-sm text-gray-400">{{ ucfirst($latestVehicle->vehicle_type) }} - {{ $latestVehicle->brand }} {{ $latestVehicle->model }}</p>
                                        </div>
                                    @else
                                        <p class="text-gray-400">No vehicles registered yet</p>
                                    @endif
                                </div>
                            </div>

                            <div class="cta-section">
                                <a href="{{ route('vehicles.manage') }}" 
                                   class="inline-flex items-center px-8 py-4 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition-colors">
                                    Manage Vehicles
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Weather Widget -->
                        @if($weatherData)
                        <div class="weather-card rounded-2xl p-8 min-w-[300px] ml-8">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-semibold text-white mb-1">Bandung</h3>
                                    <p class="text-gray-400">Current Weather</p>
                                </div>
                                <img src="{{ $weatherData['current']['condition']['icon'] }}" 
                                     alt="Weather icon" 
                                     class="w-16 h-16">
                            </div>
                            <div class="flex items-end space-x-2">
                                <div class="text-5xl font-bold">{{ $weatherData['current']['temp_c'] }}°</div>
                                <div class="text-gray-400 mb-2">C</div>
                            </div>
                            <p class="text-gray-300 mt-2">{{ $weatherData['current']['condition']['text'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('hidden');
        }

        // Close the profile menu when clicking outside
        window.addEventListener('click', function(e) {
            const menu = document.getElementById('profileMenu');
            const profileButton = e.target.closest('button');
            if (!profileButton && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html> 