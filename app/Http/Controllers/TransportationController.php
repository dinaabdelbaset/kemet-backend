<?php

namespace App\Http\Controllers;

use App\Models\Transportation;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    public function index(Request $request)
    {
        // Auto-seed if empty
        if (Transportation::count() === 0) {
            $this->seedTransportation();
        }

        $query = Transportation::query();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        return response()->json($query->get());
    }

    public function show($id)
    {
        $transport = Transportation::find($id);
        if (!$transport) {
            return response()->json(['message' => 'Transportation not found'], 404);
        }
        return response()->json($transport);
    }

    private function seedTransportation()
    {
        $data = [
            // --- BUSES ---
            ['type' => 'Bus', 'route' => 'Cairo to Alexandria', 'company' => 'Go Bus', 'class' => 'AC', 'price' => 200, 'duration' => '3h', 'departure_time' => '07:00 AM', 'rating' => 3.8, 'image' => '/images/transport/gobus_alex_1777135693613.png'],
            ['type' => 'Bus', 'route' => 'Cairo to Sharm El-Sheikh', 'company' => 'Go Bus', 'class' => 'VIP', 'price' => 450, 'duration' => '6h', 'departure_time' => '11:00 PM', 'rating' => 4.1, 'image' => '/images/transport/gobus_sharm_1777135752658.png'],
            ['type' => 'Bus', 'route' => 'Cairo to Hurghada', 'company' => 'Go Bus', 'class' => 'VIP', 'price' => 450, 'duration' => '5h 30m', 'departure_time' => '10:00 PM', 'rating' => 4.0, 'image' => '/images/transport/gobus_egypt_1777135401883.png'],
            ['type' => 'Bus', 'route' => 'Cairo to Marsa Matrouh', 'company' => 'Go Bus', 'class' => 'VIP', 'price' => 350, 'duration' => '4h', 'departure_time' => '06:00 AM', 'rating' => 4.0, 'image' => '/images/transport/gobus_matrouh_1777135710322.png'],
            ['type' => 'Bus', 'route' => 'Cairo to Luxor', 'company' => 'Go Bus', 'class' => 'VIP', 'price' => 750, 'duration' => '9h', 'departure_time' => '08:00 PM', 'rating' => 4.4, 'image' => '/images/transport/gobus_luxor_1777135723679.png'],
            ['type' => 'Bus', 'route' => 'Cairo to Aswan', 'company' => 'Go Bus', 'class' => 'VIP', 'price' => 850, 'duration' => '12h', 'departure_time' => '07:00 PM', 'rating' => 4.3, 'image' => '/images/transport/gobus_aswan_1777135737679.png'],
            
            // --- MINIBUSES ---
            ['type' => 'Minibus', 'route' => 'Cairo to Fayoum', 'company' => 'Go Mini', 'class' => 'Standard', 'price' => 150, 'duration' => '1h 30m', 'departure_time' => 'Every Hour', 'rating' => 3.8, 'image' => '/images/transport/gomini_fayoum_1777135774005.png'],
            ['type' => 'Minibus', 'route' => 'Alexandria to Matrouh', 'company' => 'Go Mini', 'class' => 'Comfort', 'price' => 200, 'duration' => '4h', 'departure_time' => '06:00 AM', 'rating' => 4.0, 'image' => '/images/transport/gomini_matrouh_1777135790333.png'],
            ['type' => 'Minibus', 'route' => 'Hurghada to El Gouna', 'company' => 'Go Mini', 'class' => 'Standard', 'price' => 100, 'duration' => '45m', 'departure_time' => 'Every 30 mins', 'rating' => 4.3, 'image' => '/images/transport/gomini_gouna_1777135802903.png'],
            ['type' => 'Minibus', 'route' => 'Luxor to Aswan', 'company' => 'Go Mini', 'class' => 'Comfort', 'price' => 250, 'duration' => '3h', 'departure_time' => '08:00 AM', 'rating' => 4.1, 'image' => '/images/transport/gomini_luxor_1777135816125.png'],
            ['type' => 'Minibus', 'route' => 'Sharm El-Sheikh to Dahab', 'company' => 'Go Mini', 'class' => 'Standard', 'price' => 120, 'duration' => '1h 15m', 'departure_time' => '09:00 AM', 'rating' => 4.4, 'image' => '/images/transport/gomini_dahab_1777135830839.png'],

            // --- CARS (Rentals) ---
            ['type' => 'Car', 'route' => 'Cairo', 'company' => 'Kemet Luxury Rentals', 'class' => 'Sports', 'price' => 3500, 'duration' => '48h', 'departure_time' => 'On Demand', 'rating' => 4.9, 'image' => '/images/transport/luxury_car_egypt_1777135452317.png'],
            ['type' => 'Car', 'route' => 'Alexandria', 'company' => 'Kemet Luxury Rentals', 'class' => 'Sedan', 'price' => 2500, 'duration' => '48h', 'departure_time' => 'On Demand', 'rating' => 4.7, 'image' => '/images/transport/luxury_car_alex_1777135853069.png'],
            ['type' => 'Car', 'route' => 'Sharm El-Sheikh', 'company' => 'Kemet Luxury Rentals', 'class' => 'SUV', 'price' => 4000, 'duration' => '48h', 'departure_time' => 'On Demand', 'rating' => 4.8, 'image' => '/images/transport/luxury_car_sharm_1777135867358.png'],
            ['type' => 'Car', 'route' => 'Hurghada', 'company' => 'Kemet Luxury Rentals', 'class' => 'Convertible', 'price' => 4500, 'duration' => '48h', 'departure_time' => 'On Demand', 'rating' => 4.9, 'image' => '/images/transport/luxury_car_hurghada_1777135880620.png'],
            ['type' => 'Car', 'route' => 'Luxor', 'company' => 'Kemet Luxury Rentals', 'class' => 'Sedan', 'price' => 2200, 'duration' => '48h', 'departure_time' => 'On Demand', 'rating' => 4.6, 'image' => '/images/transport/luxury_car_luxor_1777135896174.png'],
            ['type' => 'Car', 'route' => 'Aswan', 'company' => 'Kemet Luxury Rentals', 'class' => 'SUV', 'price' => 3500, 'duration' => '48h', 'departure_time' => 'On Demand', 'rating' => 4.5, 'image' => '/images/transport/luxury_car_aswan_1777135909165.png'],
        ];

        foreach ($data as $item) {
            Transportation::create($item);
        }
    }
}
