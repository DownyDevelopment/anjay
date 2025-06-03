<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    private $weatherApiKey = '43c4bc48d15747769d063234252905';
    private $weatherApiBaseUrl = 'https://api.weatherapi.com/v1';

    public function index()
    {
        try {
            $response = Http::timeout(30)->get($this->weatherApiBaseUrl . '/current.json', [
                'key' => $this->weatherApiKey,
                'q' => 'Bandung',
                'aqi' => 'no'
            ]);

            if ($response->successful()) {
                $weatherData = $response->json();
            } else {
                $weatherData = null;
            }
        } catch (\Exception $e) {
            $weatherData = null;
        }

        // Get vehicle statistics
        $totalMotorcycles = Vehicle::where('vehicle_type', 'motorcycle')->count();
        $totalCars = Vehicle::where('vehicle_type', 'car')->count();
        $latestVehicle = Vehicle::latest()->first();

        return view('dashboard', compact('weatherData', 'totalMotorcycles', 'totalCars', 'latestVehicle'));
    }

    public function manage()
    {
        $vehicles = Vehicle::latest()->get();
        return view('vehicles.manage', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_id' => 'required|string|unique:vehicles',
            'license_plate' => 'required|string|unique:vehicles',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'vehicle_type' => 'required|in:car,motorcycle',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.manage')
            ->with('success', 'Vehicle added successfully!');
    }

    public function edit(Vehicle $vehicle)
    {
        return response()->json($vehicle);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_id' => 'required|string|unique:vehicles,student_id,' . $vehicle->id,
            'license_plate' => 'required|string|unique:vehicles,license_plate,' . $vehicle->id,
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'vehicle_type' => 'required|in:car,motorcycle',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.manage')
            ->with('success', 'Vehicle updated successfully!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.manage')
            ->with('success', 'Vehicle deleted successfully!');
    }
} 