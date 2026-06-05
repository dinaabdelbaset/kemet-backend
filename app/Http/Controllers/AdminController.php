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
        // If there are zero bookings in the database, automatically seed a few realistic bookings spread over the last 6 months
        // This ensures the dashboard instantly has rich, beautiful, interactive data for testing, while remaining 100% reactive to new bookings!
        if (Booking::count() === 0) {
            $user = User::first();
            if (!$user) {
                $user = User::create([
                    'name' => 'dina Admin',
                    'email' => 'admin@kemat.com',
                    'password' => \Hash::make('password123'),
                ]);
            }

            // A set of realistic local services & pricing
            $services = [
                ['title' => 'Giza Pyramids Guided Tour', 'type' => 'tour', 'price' => 1200],
                ['title' => 'Dahab Luxury Resort Room', 'type' => 'hotel', 'price' => 3500],
                ['title' => 'Luxor & Aswan Nile Cruise', 'type' => 'tour', 'price' => 5400],
                ['title' => 'Sharm El Sheikh Marriott', 'type' => 'hotel', 'price' => 4200],
                ['title' => 'Siwa Oasis Safari Expedition', 'type' => 'safari', 'price' => 2800],
                ['title' => 'Flight Ticket MS-779 (Cairo-Aswan)', 'type' => 'flight', 'price' => 1800],
            ];

            // Seed bookings for the last 14 days
            for ($i = 13; $i >= 0; $i--) {
                $date = now()->subDays($i);
                // Create random number of bookings for this day
                $numBookings = rand(1, 4);
                for ($j = 0; $j < $numBookings; $j++) {
                    $service = $services[array_rand($services)];
                    $guests = rand(1, 4);
                    $totalPrice = $service['price'] * $guests;

                    $b = new Booking();
                    $b->user_id = $user->id;
                    $b->item_type = $service['type'];
                    $b->item_title = $service['title'];
                    $b->item_id = rand(1, 10);
                    $b->status = 'confirmed';
                    $b->total_price = $totalPrice;
                    $b->guests = $guests;
                    $b->date_info = $date->format('Y-m-d') . ' to ' . $date->copy()->addDays(3)->format('Y-m-d');
                    
                    // Set created_at to a random time within this day
                    $simulatedDate = $date->copy()->hour(rand(9, 21))->minute(rand(0, 59));
                    
                    $b->created_at = $simulatedDate;
                    $b->updated_at = $simulatedDate;
                    $b->save();
                }
            }
        }

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

        // Aggregate actual revenue & count from non-cancelled bookings
        $revenue = Booking::where('status', '!=', 'cancelled')->sum('total_price');
        $profit = $revenue * $commissionFraction; // dynamic platform commission

        // Get Top Places (most booked item_titles)
        $topPlaces = \DB::table('bookings')
            ->select('item_title as name', \DB::raw('count(*) as visits'))
            ->where('status', '!=', 'cancelled')
            ->whereNotNull('item_title')
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

        // Group actual bookings by day for the last 14 days
        $historicalData = [];
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayName = $date->format('M d'); // e.g. "Jun 01"

            $bookingsCount = Booking::where('status', '!=', 'cancelled')
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->count();

            $revenueSum = Booking::where('status', '!=', 'cancelled')
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->sum('total_price');

            $historicalData[] = [
                'name' => $dayName,
                'revenue' => floatval($revenueSum),
                'bookings' => intval($bookingsCount),
            ];
        }

        return response()->json([
            'users' => User::count(),
            'bookings' => Booking::count(),
            'hotels' => Hotel::count(),
            'revenue' => $revenue,
            'profit' => $profit,
            'commission_rate' => $commissionRate,
            'top_places' => $topPlaces,
            'top_users' => $topUsers,
            'historical_data' => $historicalData
        ]);
    }

    private function handleImageUpload(Request $request, $data) {
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/uploads'), $filename);
            $data['image'] = url('/images/uploads/' . $filename);
        }
        if (!isset($data['status'])) {
            $data['status'] = 'approved';
        }
        return $data;
    }

    public function updateSettings(Request $request)
    {
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }

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
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
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

    public function getUserNotes($id)
    {
        $user = User::with('notes')->find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);
        return response()->json($user->notes()->orderBy('created_at', 'desc')->get());
    }

    public function getUserBookings($id)
    {
        $user = User::with('bookings')->find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);
        return response()->json($user->bookings()->orderBy('created_at', 'desc')->get());
    }

    public function addUserNote(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);

        $request->validate([
            'content' => 'required|string',
            'type' => 'nullable|string'
        ]);

        $note = $user->notes()->create([
            'content' => $request->input('content'),
            'type' => $request->input('type') ?? 'note',
            'admin_name' => 'Admin' // Assuming single admin or get from auth
        ]);

        return response()->json($note, 201);
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
        
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }
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

        public function rooms()
    {
        return response()->json(\App\Models\Room::with('hotel')->orderBy('id', 'desc')->get());
    }

    public function storeRoom(Request $request)
    {
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        $item = \App\Models\Room::create($data);
        return response()->json($item, 201);
    }

    public function updateRoom(Request $request, $id)
    {
        $item = \App\Models\Room::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        $item->update($data);
        return response()->json($item);
    }

    public function deleteRoom($id)
    {
        $item = \App\Models\Room::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function hotels()
    {
        return response()->json(Hotel::orderBy('id', 'desc')->get());
    }

    public function storeHotel(Request $request)
    {
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }
        
        $hotel = Hotel::create($data);
        return response()->json($hotel, 201);
    }

    public function updateHotel(Request $request, $id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) return response()->json(['message' => 'Hotel not found'], 404);

        // Start with only the fields we want to update (whitelist approach)
        $data = $request->only(['name', 'location', 'price', 'rating', 'description', 'status']);

        // Map name → title
        if (isset($data['name']) && $data['name'] !== '') {
            $data['title'] = $data['name'];
        }
        unset($data['name']);

        // Map price → price_starts_from
        if (isset($data['price']) && $data['price'] !== '') {
            $data['price_starts_from'] = $data['price'];
        }
        unset($data['price']);

        // Only upload new image if a file was actually sent
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/uploads'), $filename);
            $data['image'] = url('/images/uploads/' . $filename);
        }
        // else: keep existing hotel->image untouched

        $hotel->update($data);
        return response()->json($hotel->fresh());
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
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }
        
        $tour = \App\Models\Tour::create($data);
        return response()->json($tour, 201);
    }

    public function updateTour(Request $request, $id)
    {
        $tour = \App\Models\Tour::find($id);
        if (!$tour) return response()->json(['message' => 'Tour not found'], 404);

        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }

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
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }
        
        $item = \App\Models\Safari::create($data);
        return response()->json($item, 201);
    }

    public function updateSafari(Request $request, $id)
    {
        $item = \App\Models\Safari::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }

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
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        // Restaurants use 'name' and 'price_range_min'/'price_range_max'
        if (isset($data['price'])) {
            $data['price_range_min'] = $data['price'];
            $data['price_range_max'] = $data['price'];
        }
        
        $item = \App\Models\Restaurant::create($data);
        return response()->json($item, 201);
    }

    public function updateRestaurant(Request $request, $id)
    {
        $item = \App\Models\Restaurant::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        // Restaurants use 'name' and 'price_range_min'/'price_range_max'
        if (isset($data['price'])) {
            $data['price_range_min'] = $data['price'];
            $data['price_range_max'] = $data['price'];
        }

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
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        // Museums use 'name' and 'ticket_price'
        if (isset($data['price'])) {
            $data['ticket_price'] = $data['price'];
        }
        
        $item = \App\Models\Museum::create($data);
        return response()->json($item, 201);
    }

    public function updateMuseum(Request $request, $id)
    {
        $item = \App\Models\Museum::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        // Museums use 'name' and 'ticket_price'
        if (isset($data['price'])) {
            $data['ticket_price'] = $data['price'];
        }

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
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }
        
        $item = \App\Models\Event::create($data);
        return response()->json($item, 201);
    }

    public function updateEvent(Request $request, $id)
    {
        $item = \App\Models\Event::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }

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
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }
        
        $item = \App\Models\Bazaar::create($data);
        return response()->json($item, 201);
    }

    public function updateBazaar(Request $request, $id)
    {
        $item = \App\Models\Bazaar::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }

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
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }
        
        $item = \App\Models\Transportation::create($data);
        return response()->json($item, 201);
    }

    public function updateTransportation(Request $request, $id)
    {
        $item = \App\Models\Transportation::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }

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
        $data = $this->handleImageUpload($request, $data);
        
        $item = \App\Models\TravelPackage::create($data);
        return response()->json($item, 201);
    }

    public function updateTravelPackage(Request $request, $id)
    {
        if (!class_exists('\App\Models\TravelPackage')) return response()->json(['message' => 'Model not found'], 404);
        $item = \App\Models\TravelPackage::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
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
        $data = $this->handleImageUpload($request, $data);
        
        $item = \App\Models\Review::create($data);
        return response()->json($item, 201);
    }

    public function updateReview(Request $request, $id)
    {
        if (!class_exists('\App\Models\Review')) return response()->json(['message' => 'Model not found'], 404);
        $item = \App\Models\Review::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
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
        $data = $this->handleImageUpload($request, $data);
        
        $item = \App\Models\Deal::create($data);
        return response()->json($item, 201);
    }

    public function updateDeal(Request $request, $id)
    {
        if (!class_exists('\App\Models\Deal')) return response()->json(['message' => 'Model not found'], 404);
        $item = \App\Models\Deal::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
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
        $data = $this->handleImageUpload($request, $data);
        $item = \App\Models\Flight::create($data);
        return response()->json($item, 201);
    }

    public function updateFlight(Request $request, $id)
    {
        if (!class_exists('\App\Models\Flight')) return response()->json(['message' => 'Model not found'], 404);
        $item = \App\Models\Flight::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);
        $data = $request->all();
        $data = $this->handleImageUpload($request, $data);
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

    // ─── ORDERS (E-Commerce & Food Orders) ───────────────────────────────────

    public function orders()
    {
        $orders = \App\Models\Order::with(['user', 'items.product'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'id'              => $order->id,
                    'user'            => $order->user ? [
                        'id'         => $order->user->id,
                        'name'       => $order->user->name ?? ($order->user->first_name . ' ' . $order->user->last_name),
                        'first_name' => $order->user->first_name,
                        'email'      => $order->user->email,
                    ] : null,
                    'hotel_name'      => $order->hotel_name,
                    'room_number'     => $order->room_number,
                    'phone'           => $order->phone,
                    'delivery_date'   => $order->delivery_date,
                    'delivery_time'   => $order->delivery_time,
                    'total_amount'    => $order->total_amount,
                    'payment_method'  => $order->payment_method,
                    'status'          => $order->status,
                    'created_at'      => $order->created_at,
                    'items'           => $order->items->map(function ($item) {
                        return [
                            'id'         => $item->id,
                            'product_id' => $item->product_id,
                            'quantity'   => $item->quantity,
                            'price'      => $item->price,
                            'product'    => $item->product ? [
                                'id'    => $item->product->id,
                                'name'  => $item->product->name,
                                'image' => $item->product->image,
                            ] : null,
                        ];
                    }),
                ];
            });

        return response()->json($orders);
    }

    public function updateOrder(Request $request, $id)
    {
        $order = \App\Models\Order::find($id);
        if (!$order) return response()->json(['message' => 'Order not found'], 404);

        $request->validate([
            'status' => 'required|string|in:Pending,Processing,Delivered,Cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Order status updated', 'order' => $order]);
    }

    public function deleteOrder($id)
    {
        $order = \App\Models\Order::find($id);
        if (!$order) return response()->json(['message' => 'Order not found'], 404);

        // Delete related order items first
        $order->items()->delete();
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
