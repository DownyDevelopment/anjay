<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Management - Telkom University Parking</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-black text-white">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="border-b border-gray-800 bg-black">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('dashboard') }}" class="flex-shrink-0">
                            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-auto">
                        </a>
                        <div class="hidden md:flex space-x-8">
                            <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white">Dashboard</a>
                            <a href="{{ route('vehicles.manage') }}" class="text-white font-medium">Manage</a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" 
                                   id="searchInput" 
                                   placeholder="Search by ID or Vehicle Number" 
                                   class="w-64 bg-gray-900 text-white px-4 py-2 rounded-lg border border-gray-700 focus:outline-none focus:border-purple-500">
                        </div>
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
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Success Message -->
            @if(session('success'))
            <div id="successAlert" class="mb-4 bg-green-900 border border-green-500 text-green-300 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button onclick="document.getElementById('successAlert').remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-300" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
            @endif

            <!-- Error Message -->
            @if($errors->any())
            <div id="errorAlert" class="mb-4 bg-red-900 border border-red-500 text-red-300 px-4 py-3 rounded relative" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button onclick="document.getElementById('errorAlert').remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-300" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-white">Users</h1>
                    <p class="text-gray-400 mt-1">A list of all the users in your account including their student ID, and Vehicle Number.</p>
                </div>
                <button onclick="document.getElementById('addVehicleModal').classList.remove('hidden')" 
                        class="bg-yellow-400 text-black px-4 py-2 rounded-lg hover:bg-yellow-300">
                    Add user
                </button>
            </div>

            <!-- Users Table -->
            <div class="bg-gray-900 rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-800">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Student ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Vehicle Number</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($vehicles as $vehicle)
                        <tr class="hover:bg-gray-800 vehicle-row">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-white">{{ $vehicle->student_name }}</div>
                                    <div class="text-sm text-gray-400 student-id">{{ $vehicle->student_id }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-white vehicle-number">{{ $vehicle->license_plate }}</td>
                            <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                                <button onclick="editVehicle({{ $vehicle->id }})" class="text-purple-400 hover:text-purple-300">Edit</button>
                                <button onclick="deleteVehicle({{ $vehicle->id }})" class="text-gray-400 hover:text-gray-300">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Add Vehicle Modal -->
    <div id="addVehicleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-gray-900 rounded-lg p-8 max-w-md w-full">
            <h3 class="text-xl font-bold text-white mb-4">Add New Vehicle</h3>
            <form action="{{ route('vehicles.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Student Name</label>
                        <input type="text" name="student_name" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Student ID</label>
                        <input type="text" name="student_id" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">License Plate</label>
                        <input type="text" name="license_plate" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Brand</label>
                        <input type="text" name="brand" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Model</label>
                        <input type="text" name="model" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Color</label>
                        <input type="text" name="color" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Vehicle Type</label>
                        <select name="vehicle_type" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="car">Car</option>
                            <option value="motorcycle">Motorcycle</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('addVehicleModal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-800">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-yellow-400 text-black rounded-md hover:bg-yellow-300">
                        Add Vehicle
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Vehicle Modal -->
    <div id="editVehicleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-gray-900 rounded-lg p-8 max-w-md w-full">
            <h3 class="text-xl font-bold text-white mb-4">Edit Vehicle</h3>
            <form id="editVehicleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Student Name</label>
                        <input type="text" name="student_name" id="edit_student_name" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Student ID</label>
                        <input type="text" name="student_id" id="edit_student_id" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">License Plate</label>
                        <input type="text" name="license_plate" id="edit_license_plate" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Brand</label>
                        <input type="text" name="brand" id="edit_brand" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Model</label>
                        <input type="text" name="model" id="edit_model" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Color</label>
                        <input type="text" name="color" id="edit_color" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Vehicle Type</label>
                        <select name="vehicle_type" id="edit_vehicle_type" class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="car">Car</option>
                            <option value="motorcycle">Motorcycle</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('editVehicleModal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-800">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-yellow-400 text-black rounded-md hover:bg-yellow-300">
                        Update Vehicle
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-gray-900 rounded-lg p-8 max-w-md w-full">
            <h3 class="text-xl font-bold text-white mb-4">Confirm Delete</h3>
            <p class="text-gray-300 mb-6">Are you sure you want to delete this vehicle? This action cannot be undone.</p>
            <form id="deleteVehicleForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('deleteConfirmModal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-800">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </form>
        </div>
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

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            const searchValue = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.vehicle-row');

            rows.forEach(row => {
                const studentId = row.querySelector('.student-id').textContent.toLowerCase();
                const vehicleNumber = row.querySelector('.vehicle-number').textContent.toLowerCase();
                
                if (studentId.includes(searchValue) || vehicleNumber.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        async function editVehicle(id) {
            try {
                const response = await fetch(`/vehicles/${id}/edit`);
                const vehicle = await response.json();
                
                // Populate the edit form
                document.getElementById('edit_student_name').value = vehicle.student_name;
                document.getElementById('edit_student_id').value = vehicle.student_id;
                document.getElementById('edit_license_plate').value = vehicle.license_plate;
                document.getElementById('edit_brand').value = vehicle.brand;
                document.getElementById('edit_model').value = vehicle.model;
                document.getElementById('edit_color').value = vehicle.color;
                document.getElementById('edit_vehicle_type').value = vehicle.vehicle_type;
                
                // Set the form action
                document.getElementById('editVehicleForm').action = `/vehicles/${id}`;
                
                // Show the modal
                document.getElementById('editVehicleModal').classList.remove('hidden');
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function deleteVehicle(id) {
            document.getElementById('deleteVehicleForm').action = `/vehicles/${id}`;
            document.getElementById('deleteConfirmModal').classList.remove('hidden');
        }
    </script>
</body>
</html> 