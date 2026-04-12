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
        $revenue = Booking::where('status', '!=', 'cancelled')->sum('total_price');
        $profit = $revenue * 0.15; // 15% platform commission

        return response()->json([
            'users' => User::count(),
            'bookings' => Booking::count(),
            'hotels' => Hotel::count(),
            'revenue' => $revenue,
            'profit' => $profit,
            'commission_rate' => '15%',
        ]);
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
        return response()->json(Booking::with('user')->orderBy('id', 'desc')->get());
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
}
