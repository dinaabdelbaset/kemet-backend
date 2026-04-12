<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function stats()
    {
        $settingsPath = storage_path('app/settings.json');
        $commissionRate = '15%';
        $commissionFraction = 0.15;
        
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            if (isset($settings['commission_rate'])) {
                $commissionRate = $settings['commission_rate'];
                $val = floatval(str_replace('%', '', $commissionRate));
                $commissionFraction = $val / 100;
            }
        }

        $revenue = Booking::where('status', '!=', 'cancelled')->sum('total_price');
        $profit = $revenue * $commissionFraction; // dynamic platform commission

        // Get Top Places (most booked item_titles)
        $topPlaces = \DB::table('bookings')
            ->select('item_title as name', \DB::raw('count(*) as visits'))
            ->where('status', '!=', 'cancelled')
            ->groupBy('item_title')
            ->orderByDesc('visits')
            ->limit(4)
            ->get();

        // Get Best Users (users with most bookings)
        $topUsers = User::withCount(['bookings' => function($query) {
                $query->where('status', '!=', 'cancelled');
            }])
            ->orderByDesc('bookings_count')
            ->limit(4)
            ->get()
            ->map(function($user) {
                return [
                    'name' => $user->name ?? ($user->first_name . ' ' . $user->last_name),
                    'bookings' => $user->bookings_count
                ];
            });

        return response()->json([
            'users' => User::count(),
            'bookings' => Booking::count(),
            'hotels' => Hotel::count(),
            'revenue' => $revenue,
            'profit' => $profit,
            'commission_rate' => $commissionRate,
            'top_places' => $topPlaces,
            'top_users' => $topUsers
        ]);
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'commission_rate' => 'required|string'
        ]);

        $settings = [];
        $settingsPath = storage_path('app/settings.json');
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true) ?? [];
        }
        $settings['commission_rate'] = $data['commission_rate'];
        file_put_contents($settingsPath, json_encode($settings));

        return response()->json(['message' => 'Settings updated', 'settings' => $settings]);
    }

    public function users()
    {
        return response()->json(User::orderBy('id', 'desc')->get());
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'Not found'], 404);
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string'
        ]);
        $user->update($data);
        return response()->json($user);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    public function bookings()
    {
        $settingsPath = storage_path('app/settings.json');
        $commissionFraction = 0.15;
        
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            if (isset($settings['commission_rate'])) {
                $compRate = floatval(str_replace('%', '', $settings['commission_rate']));
                $commissionFraction = $compRate / 100;
            }
        }

        $bookings = Booking::with('user')->orderBy('id', 'desc')->get()->map(function($booking) use ($commissionFraction) {
            $booking->platform_profit = round($booking->total_price * $commissionFraction, 2);
            $booking->partner_share = round($booking->total_price - $booking->platform_profit, 2);
            $booking->commission_percentage = ($commissionFraction * 100) . '%';
            return $booking;
        });

        return response()->json($bookings);
    }

    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::find($id);
        if (!$booking) return response()->json(['message' => 'Not found'], 404);
        
        $data = $request->validate([
            'status' => 'required|string'
        ]);
        $booking->update($data);
        return response()->json($booking);
    }

    public function deleteBooking($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            $booking->delete();
            return response()->json(['message' => 'Booking deleted successfully']);
        }
        return response()->json(['message' => 'Booking not found'], 404);
    }

    public function hotels()
    {
        return response()->json(Hotel::orderBy('id', 'desc')->get());
    }

    public function storeHotel(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'required|string',
            'price_starts_from' => 'required|numeric',
            'image' => 'nullable|string'
        ]);
        
        $hotel = Hotel::create($data);
        return response()->json($hotel, 201);
    }

    public function updateHotel(Request $request, $id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) return response()->json(['message' => 'Hotel not found'], 404);

        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'required|string',
            'price_starts_from' => 'required|numeric',
            'image' => 'nullable|string'
        ]);

        $hotel->update($data);
        return response()->json($hotel);
    }

    public function deleteHotel($id)
    {
        $hotel = Hotel::find($id);
        if ($hotel) {
            $hotel->delete();
            return response()->json(['message' => 'Hotel deleted successfully']);
        }
        return response()->json(['message' => 'Hotel not found'], 404);
    }

    public function tours()
    {
        return response()->json(\App\Models\Tour::orderBy('id', 'desc')->get());
    }

    public function storeTour(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'nullable|string',
            'image' => 'nullable|string'
        ]);
        
        $tour = \App\Models\Tour::create($data);
        return response()->json($tour, 201);
    }

    public function updateTour(Request $request, $id)
    {
        $tour = \App\Models\Tour::find($id);
        if (!$tour) return response()->json(['message' => 'Tour not found'], 404);

        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'nullable|string',
            'image' => 'nullable|string'
        ]);

        $tour->update($data);
        return response()->json($tour);
    }

    public function deleteTour($id)
    {
        $tour = \App\Models\Tour::find($id);
        if ($tour) {
            $tour->delete();
            return response()->json(['message' => 'Tour deleted successfully']);
        }
        return response()->json(['message' => 'Tour not found'], 404);
    }

    public function safaris()
    {
        return response()->json(\App\Models\Safari::orderBy('id', 'desc')->get());
    }

    public function storeSafari(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);
        
        $item = \App\Models\Safari::create($data);
        return response()->json($item, 201);
    }

    public function updateSafari(Request $request, $id)
    {
        $item = \App\Models\Safari::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);

        $item->update($data);
        return response()->json($item);
    }

    public function deleteSafari($id)
    {
        $item = \App\Models\Safari::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function restaurants()
    {
        return response()->json(\App\Models\Restaurant::orderBy('id', 'desc')->get());
    }

    public function storeRestaurant(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);
        
        $item = \App\Models\Restaurant::create($data);
        return response()->json($item, 201);
    }

    public function updateRestaurant(Request $request, $id)
    {
        $item = \App\Models\Restaurant::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);

        $item->update($data);
        return response()->json($item);
    }

    public function deleteRestaurant($id)
    {
        $item = \App\Models\Restaurant::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function museums()
    {
        return response()->json(\App\Models\Museum::orderBy('id', 'desc')->get());
    }

    public function storeMuseum(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);
        
        $item = \App\Models\Museum::create($data);
        return response()->json($item, 201);
    }

    public function updateMuseum(Request $request, $id)
    {
        $item = \App\Models\Museum::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);

        $item->update($data);
        return response()->json($item);
    }

    public function deleteMuseum($id)
    {
        $item = \App\Models\Museum::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function events()
    {
        return response()->json(\App\Models\Event::orderBy('id', 'desc')->get());
    }

    public function storeEvent(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);
        
        $item = \App\Models\Event::create($data);
        return response()->json($item, 201);
    }

    public function updateEvent(Request $request, $id)
    {
        $item = \App\Models\Event::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);

        $item->update($data);
        return response()->json($item);
    }

    public function deleteEvent($id)
    {
        $item = \App\Models\Event::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function bazaars()
    {
        return response()->json(\App\Models\Bazaar::orderBy('id', 'desc')->get());
    }

    public function storeBazaar(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);
        
        $item = \App\Models\Bazaar::create($data);
        return response()->json($item, 201);
    }

    public function updateBazaar(Request $request, $id)
    {
        $item = \App\Models\Bazaar::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);

        $item->update($data);
        return response()->json($item);
    }

    public function deleteBazaar($id)
    {
        $item = \App\Models\Bazaar::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function transportations()
    {
        return response()->json(\App\Models\Transportation::orderBy('id', 'desc')->get());
    }

    public function storeTransportation(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);
        
        $item = \App\Models\Transportation::create($data);
        return response()->json($item, 201);
    }

    public function updateTransportation(Request $request, $id)
    {
        $item = \App\Models\Transportation::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->validate([
            'title' => 'required|string',
            'location' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);

        $item->update($data);
        return response()->json($item);
    }

    public function deleteTransportation($id)
    {
        $item = \App\Models\Transportation::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }


    public function travelpackages()
    {
        if (class_exists('\App\Models\TravelPackage')) {
             return response()->json(\App\Models\TravelPackage::orderBy('id', 'desc')->get());
        }
        return response()->json([]);
    }

    public function storeTravelPackage(Request $request)
    {
        if (!class_exists('\App\Models\TravelPackage')) return response()->json(['message' => 'Model not found'], 404);
        
        $data = $request->all();
        
        $item = \App\Models\TravelPackage::create($data);
        return response()->json($item, 201);
    }

    public function updateTravelPackage(Request $request, $id)
    {
        if (!class_exists('\App\Models\TravelPackage')) return response()->json(['message' => 'Model not found'], 404);
        $item = \App\Models\TravelPackage::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->all();
        $item->update($data);
        return response()->json($item);
    }

    public function deleteTravelPackage($id)
    {
        if (!class_exists('\App\Models\TravelPackage')) return response()->json(['message' => 'Model not found'], 404);
        $item = \App\Models\TravelPackage::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function reviews()
    {
        if (class_exists('\App\Models\Review')) {
             return response()->json(\App\Models\Review::orderBy('id', 'desc')->get());
        }
        return response()->json([]);
    }

    public function storeReview(Request $request)
    {
        if (!class_exists('\App\Models\Review')) return response()->json(['message' => 'Model not found'], 404);
        
        $data = $request->all();
        
        $item = \App\Models\Review::create($data);
        return response()->json($item, 201);
    }

    public function updateReview(Request $request, $id)
    {
        if (!class_exists('\App\Models\Review')) return response()->json(['message' => 'Model not found'], 404);
        $item = \App\Models\Review::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->all();
        $item->update($data);
        return response()->json($item);
    }

    public function deleteReview($id)
    {
        if (!class_exists('\App\Models\Review')) return response()->json(['message' => 'Model not found'], 404);
        $item = \App\Models\Review::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function deals()
    {
        if (class_exists('\App\Models\Deal')) {
             return response()->json(\App\Models\Deal::orderBy('id', 'desc')->get());
        }
        return response()->json([]);
    }

    public function storeDeal(Request $request)
    {
        if (!class_exists('\App\Models\Deal')) return response()->json(['message' => 'Model not found'], 404);
        
        $data = $request->all();
        
        $item = \App\Models\Deal::create($data);
        return response()->json($item, 201);
    }

    public function updateDeal(Request $request, $id)
    {
        if (!class_exists('\App\Models\Deal')) return response()->json(['message' => 'Model not found'], 404);
        $item = \App\Models\Deal::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->all();
        $item->update($data);
        return response()->json($item);
    }

    public function deleteDeal($id)
    {
        if (!class_exists('\App\Models\Deal')) return response()->json(['message' => 'Model not found'], 404);
        $item = \App\Models\Deal::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function flights()
    {
        if (class_exists('\App\Models\Flight')) {
             return response()->json(\App\Models\Flight::orderBy('id', 'desc')->get());
        }
        return response()->json([]);
    }

    public function storeFlight(Request $request)
    {
        if (!class_exists('\App\Models\Flight')) return response()->json(['message' => 'Model not found'], 404);
        $data = $request->all();
        $item = \App\Models\Flight::create($data);
        return response()->json($item, 201);
    }

    public function updateFlight(Request $request, $id)
    {
        if (!class_exists('\App\Models\Flight')) return response()->json(['message' => 'Model not found'], 404);
        $item = \App\Models\Flight::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);
        $data = $request->all();
        $item->update($data);
        return response()->json($item);
    }

    public function deleteFlight($id)
    {
        if (!class_exists('\App\Models\Flight')) return response()->json(['message' => 'Model not found'], 404);
        $item = \App\Models\Flight::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
