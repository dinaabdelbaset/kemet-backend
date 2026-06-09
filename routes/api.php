<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\KemetChatbotController;
use App\Http\Controllers\VisionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\TravelPackageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MuseumController;
use App\Http\Controllers\SafariController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\AttractionController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BazaarController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminApprovalController;
use App\Http\Controllers\EmergencyServiceController;
use App\Http\Controllers\ArabWorldController;

Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF cookie set']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected by X-Admin-Key header middleware)
| The key is defined in .env as ADMIN_SECRET_KEY
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('admin.key')->group(function () {
    Route::get('/stats', [AdminController::class, 'stats']);
    Route::post('/settings', [AdminController::class, 'updateSettings']);
    
    Route::get('/users', [AdminController::class, 'users']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    Route::get('/users/{id}/notes', [AdminController::class, 'getUserNotes']);
    Route::post('/users/{id}/notes', [AdminController::class, 'addUserNote']);
    Route::get('/users/{id}/bookings', [AdminController::class, 'getUserBookings']);
    
    Route::get('/bookings', [AdminController::class, 'bookings']);
    Route::put('/bookings/{id}', [AdminController::class, 'updateBooking']);
    Route::delete('/bookings/{id}', [AdminController::class, 'deleteBooking']);
    
    Route::get('/hotels', [AdminController::class, 'hotels']);
    Route::get('/rooms', [AdminController::class, 'rooms']);
    Route::post('/rooms', [AdminController::class, 'storeRoom']);
    Route::put('/rooms/{id}', [AdminController::class, 'updateRoom']);
    Route::delete('/rooms/{id}', [AdminController::class, 'deleteRoom']);
    Route::post('/hotels', [AdminController::class, 'storeHotel']);
    Route::put('/hotels/{id}', [AdminController::class, 'updateHotel']);
    Route::delete('/hotels/{id}', [AdminController::class, 'deleteHotel']);

    Route::get('/tours', [AdminController::class, 'tours']);
    Route::post('/tours', [AdminController::class, 'storeTour']);
    Route::put('/tours/{id}', [AdminController::class, 'updateTour']);
    Route::delete('/tours/{id}', [AdminController::class, 'deleteTour']);

    Route::get('/safaris', [AdminController::class, 'safaris']);
    Route::post('/safaris', [AdminController::class, 'storeSafari']);
    Route::put('/safaris/{id}', [AdminController::class, 'updateSafari']);
    Route::delete('/safaris/{id}', [AdminController::class, 'deleteSafari']);

    Route::get('/restaurants', [AdminController::class, 'restaurants']);
    Route::post('/restaurants', [AdminController::class, 'storeRestaurant']);
    Route::put('/restaurants/{id}', [AdminController::class, 'updateRestaurant']);
    Route::delete('/restaurants/{id}', [AdminController::class, 'deleteRestaurant']);

    Route::get('/museums', [AdminController::class, 'museums']);
    Route::post('/museums', [AdminController::class, 'storeMuseum']);
    Route::put('/museums/{id}', [AdminController::class, 'updateMuseum']);
    Route::delete('/museums/{id}', [AdminController::class, 'deleteMuseum']);

    Route::get('/events', [AdminController::class, 'events']);
    Route::post('/events', [AdminController::class, 'storeEvent']);
    Route::put('/events/{id}', [AdminController::class, 'updateEvent']);
    Route::delete('/events/{id}', [AdminController::class, 'deleteEvent']);

    Route::get('/bazaars', [AdminController::class, 'bazaars']);
    Route::post('/bazaars', [AdminController::class, 'storeBazaar']);
    Route::put('/bazaars/{id}', [AdminController::class, 'updateBazaar']);
    Route::delete('/bazaars/{id}', [AdminController::class, 'deleteBazaar']);


    Route::get('/transportations', [AdminController::class, 'transportations']);
    Route::post('/transportations', [AdminController::class, 'storeTransportation']);
    Route::put('/transportations/{id}', [AdminController::class, 'updateTransportation']);
    Route::delete('/transportations/{id}', [AdminController::class, 'deleteTransportation']);

    Route::get('/travelpackages', [AdminController::class, 'travelpackages']);
    Route::post('/travelpackages', [AdminController::class, 'storeTravelPackage']);
    Route::put('/travelpackages/{id}', [AdminController::class, 'updateTravelPackage']);
    Route::delete('/travelpackages/{id}', [AdminController::class, 'deleteTravelPackage']);

    Route::get('/deals', [AdminController::class, 'deals']);
    Route::post('/deals', [AdminController::class, 'storeDeal']);
    Route::put('/deals/{id}', [AdminController::class, 'updateDeal']);
    Route::delete('/deals/{id}', [AdminController::class, 'deleteDeal']);

    Route::get('/flights', [AdminController::class, 'flights']);
    Route::post('/flights', [AdminController::class, 'storeFlight']);
    Route::put('/flights/{id}', [AdminController::class, 'updateFlight']);
    Route::delete('/flights/{id}', [AdminController::class, 'deleteFlight']);

    // Admin Approvals
    Route::get('/approvals/pending', [AdminApprovalController::class, 'getPendingItems']);
    Route::post('/approvals/{type}/{id}', [AdminApprovalController::class, 'moderateItem']);

    // Admin Orders (E-Commerce & Food Delivery)
    Route::get('/orders', [AdminController::class, 'orders']);
    Route::put('/orders/{id}', [AdminController::class, 'updateOrder']);
    Route::delete('/orders/{id}', [AdminController::class, 'deleteOrder']);

    // Admin Emergency Services
    Route::get('/emergency-services', [EmergencyServiceController::class, 'index']);
    Route::post('/emergency-services', [EmergencyServiceController::class, 'store']);
    Route::put('/emergency-services/{id}', [EmergencyServiceController::class, 'update']);
    Route::delete('/emergency-services/{id}', [EmergencyServiceController::class, 'destroy']);

    // Admin Arab World Tourism
    Route::post('/arab-world/countries', [ArabWorldController::class, 'storeCountry']);
    Route::put('/arab-world/countries/{id}', [ArabWorldController::class, 'updateCountry']);
    Route::delete('/arab-world/countries/{id}', [ArabWorldController::class, 'destroyCountry']);
    Route::post('/arab-world/landmarks', [ArabWorldController::class, 'storeLandmark']);
    Route::put('/arab-world/landmarks/{id}', [ArabWorldController::class, 'updateLandmark']);
    Route::delete('/arab-world/landmarks/{id}', [ArabWorldController::class, 'destroyLandmark']);

    // Admin Hajj & Umrah Packages
    Route::post('/hajj-umrah/packages', [\App\Http\Controllers\HajjUmrahController::class, 'storePackage']);
    Route::put('/hajj-umrah/packages/{id}', [\App\Http\Controllers\HajjUmrahController::class, 'updatePackage']);
    Route::delete('/hajj-umrah/packages/{id}', [\App\Http\Controllers\HajjUmrahController::class, 'destroyPackage']);
});

// ===== Utility: Force re-seed Hajj & Umrah packages (public, no key needed) =====
Route::get('/hajj-umrah-reseed', [\App\Http\Controllers\HajjUmrahController::class, 'reseed']);

// ===== Utility: Force re-seed bazaars with correct Arabic locations (public, no key needed) =====
Route::get('/bazaars-reseed', function () {
    \App\Models\Bazaar::truncate();
    app(\App\Http\Controllers\BazaarController::class)->index(); // triggers auto-seed
    return response()->json(['status' => 'Bazaars re-seeded ✅', 'count' => \App\Models\Bazaar::count()]);
});

// ===== Utility: Force re-seed safaris with English details (public, no key needed) =====
Route::get('/safaris-reseed', function () {
    \App\Models\Safari::truncate();
    
    $data = [
        // 1. Farafra
        [
            'title' => 'White Desert Camping Expedition',
            'description' => 'Two-day magical expedition to the dreamlike rock formations of the White Desert, sleeping under a canopy of stars.',
            'location' => 'White Desert National Park, Farafra',
            'duration' => '2 Days',
            'price' => 1500,
            'image' => '/images/safaris/white-desert.jpg',
            'rating' => 4.9,
            'includes' => ['All camping gear & tents', 'Bedouin barbecue dinner & breakfast', 'Star-gazing telescope tour', '4x4 desert explorer transfers'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Crystal Mountain & Black Desert Day Tour',
            'description' => 'Explore the glittering quartz crystal formations of Crystal Mountain and traverse the dark volcanic hills of the Black Desert.',
            'location' => 'Black Desert, Farafra',
            'duration' => '1 Day',
            'price' => 900,
            'image' => '/images/safaris/bahariya-oasis.jpg',
            'rating' => 4.7,
            'includes' => ['4x4 Land Cruiser transport', 'Local Oasis tour guide', 'Traditional Bedouin lunch', 'National Park entry fees'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Farafra Oasis Hot Springs & Sunset Safari',
            'description' => 'Unwind in the therapeutic warm sulfur springs of Farafra Oasis and witness a breathtaking sunset over the western sand dunes.',
            'location' => 'Hot Springs, Farafra',
            'duration' => '6 Hours',
            'price' => 700,
            'image' => '/images/safaris/siwa-adventure.jpg',
            'rating' => 4.6,
            'includes' => ['Oasis hot springs entry', 'Campfire sunset tea and snacks', 'Local Bedouin guide', 'Hotel transfers'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 2. Siwa
        [
            'title' => 'Siwa Oasis Sandboarding & 4x4 Tour',
            'description' => 'High-velocity 4x4 Land Cruiser safari across Siwa\'s legendary sand dunes, featuring sandboarding and hot spring swims.',
            'location' => 'Great Sand Sea, Siwa Oasis',
            'duration' => '1 Day',
            'price' => 800,
            'image' => '/images/safaris/siwa-adventure.jpg',
            'rating' => 4.9,
            'includes' => ['4x4 Land Cruiser transportation', 'Sandboarding gears', 'Traditional Siwan lunch', 'Cold & Hot Spring swimming visits'],
            'difficulty' => 'High',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Cleopatra Bath & Salt Lake Camel Trek',
            'description' => 'Ride a camel through lush olive groves to the historic Cleopatra Bath, and swim in the hyper-saline turquoise salt lakes of Siwa.',
            'location' => 'Salt Lakes, Siwa Oasis',
            'duration' => '4 Hours',
            'price' => 400,
            'image' => '/images/safaris/bahariya-oasis.jpg',
            'rating' => 4.8,
            'includes' => ['Camel ride guided tour', 'Salt Lake entry and swimming', 'Fresh Siwan juice and dates', 'All transport'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Shali Fortress & Sunset Dune Dinner',
            'description' => 'Hike the historic ruins of Shali Fortress followed by a magical dinner under the stars at a private Bedouin camp in the desert.',
            'location' => 'Shali Desert, Siwa Oasis',
            'duration' => '8 Hours',
            'price' => 1200,
            'image' => '/images/safaris/wadi-el-rayan.jpg',
            'rating' => 4.9,
            'includes' => ['Fortress guided tour', 'Bedouin slow-cooked dinner', 'Star-gazing camp access', '4x4 desert transfers'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 3. Sharm El-Sheikh
        [
            'title' => 'Sinai Desert Quad Bike Adventure',
            'description' => 'Thrilling desert quad biking through the Sinai Mountains, complete with a traditional Bedouin tent tea stop.',
            'location' => 'Sharm El-Sheikh Desert',
            'duration' => '3 Hours',
            'price' => 350,
            'image' => '/images/safaris/hurghada-quad.jpg',
            'rating' => 4.6,
            'includes' => ['Quad bike rental', 'Professional desert guide', 'Traditional Bedouin herbal tea', 'Hotel transfers'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Star Gaze Bedouin Dinner & Camel Ride',
            'description' => 'Enjoy a serene camel ride at sunset followed by a Bedouin barbecue dinner, belly dancing show, and telescope star-gazing.',
            'location' => 'Eco-Camp, Sharm El-Sheikh Desert',
            'duration' => '5 Hours',
            'price' => 750,
            'image' => '/images/safaris/siwa-adventure.jpg',
            'rating' => 4.8,
            'includes' => ['Camel trek experience', 'Barbecue buffet dinner', 'Folklore show performance', 'Telescope star astronomy guide'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Echo Canyon & Dune Buggy Safari',
            'description' => 'Drive a high-power dune buggy through the unique acoustic phenomenon of Echo Canyon in the Sinai Desert.',
            'location' => 'Echo Canyon, Sharm El-Sheikh Desert',
            'duration' => '4 Hours',
            'price' => 500,
            'image' => '/images/safaris/hurghada-quad.jpg',
            'rating' => 4.7,
            'includes' => ['Dune buggy rental & helmet', 'Echo Canyon photo stops', 'Professional convoy guide', 'Soft drinks and water'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 4. Fayoum
        [
            'title' => 'Wadi El Rayan & Fayoum Day Trip',
            'description' => 'Explore the stunning waterfalls of Wadi El Rayan, the ancient Whale Valley (UNESCO), and enjoy sand-boarding on golden dunes.',
            'location' => 'Fayoum',
            'duration' => '1 Day',
            'price' => 3500,
            'image' => '/images/safaris/wadi-el-rayan.jpg',
            'rating' => 4.6,
            'includes' => ['Comfortable transport', 'Entrance fees to reserves', 'Local tour guide', 'Bedouin lunch', 'Sandboarding experience'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Magic Lake Sandboarding & 4x4 Safari',
            'description' => 'A thrilling ride across the sand dunes surrounding the beautiful Magic Lake in Fayoum, with sandboarding and a lake-side camp.',
            'location' => 'Magic Lake, Fayoum',
            'duration' => '8 Hours',
            'price' => 1800,
            'image' => '/images/safaris/white-desert.jpg',
            'rating' => 4.8,
            'includes' => ['4x4 dune bashing cruiser', 'Sandboarding gear rental', 'Lake-side Bedouin lunch & tea', 'Fayoum city pickup'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Valley of Whales (Wadi Al-Hitan) Trek',
            'description' => 'Hike through the open-air museum of Wadi Al-Hitan (UNESCO World Heritage Site) to view 40-million-year-old whale fossils.',
            'location' => 'Wadi Al-Hitan, Fayoum',
            'duration' => '1 Day',
            'price' => 2200,
            'image' => '/images/safaris/wadi-el-rayan.jpg',
            'rating' => 4.9,
            'includes' => ['Fossil reserve entrance fees', 'Certified geologist guide', 'Comfortable air-conditioned transport', 'Traditional Egyptian lunch'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 5. Saint Catherine
        [
            'title' => 'Sinai Mountains & Saint Catherine Trek',
            'description' => 'Climb Mount Sinai at dawn to witness a magical sunrise, followed by a visit to the historic Saint Catherine Monastery.',
            'location' => 'Saint Catherine, South Sinai',
            'duration' => '1 Day',
            'price' => 4500,
            'image' => '/images/safaris/bahariya-oasis.jpg',
            'rating' => 4.9,
            'includes' => ['Hotel pick-up & drop-off', 'Bedouin mountain guide', 'Monastery entrance fee', 'Breakfast box', 'Hot drinks'],
            'difficulty' => 'Hard',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Mt. Sinai Sunrise Hike & Bedouin Breakfast',
            'description' => 'Embrace the challenging hike up Mt. Sinai overnight to capture the sunrise, and enjoy a hearty Bedouin breakfast at the summit.',
            'location' => 'Mount Sinai, Saint Catherine',
            'duration' => '12 Hours',
            'price' => 2500,
            'image' => '/images/safaris/white-desert.jpg',
            'rating' => 4.8,
            'includes' => ['Professional Bedouin guide', 'Traditional mountain breakfast', 'Thermal blankets at summit', 'Roundtrip hotel transfers'],
            'difficulty' => 'Hard',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Blue Desert & Canyon Photography Tour',
            'description' => 'Explore the famous painted rocks of the Blue Desert near Saint Catherine, capturing incredible desert landscape photos.',
            'location' => 'Blue Desert, Saint Catherine',
            'duration' => '1 Day',
            'price' => 3000,
            'image' => '/images/safaris/siwa-adventure.jpg',
            'rating' => 4.7,
            'includes' => ['Photography-focused guide', '4x4 transport through canyons', 'Fresh picnic lunch', 'Permits and entry fees'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 6. Cairo
        [
            'title' => 'Wadi Degla Hiking & Camping Adventure',
            'description' => 'Escape Cairo\'s hustle to Wadi Degla protectorate. Enjoy canyon hiking, mountain biking, and a campfire barbecue dinner.',
            'location' => 'Maadi, Cairo',
            'duration' => 'Half Day',
            'price' => 1500,
            'image' => '/images/safaris/white-desert.jpg',
            'rating' => 4.5,
            'includes' => ['Protectorate entry tickets', 'Professional hiking guide', 'Mountain bike rental', 'Barbecue dinner', 'Campfire drinks'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Cairo Sunset Camel Safari',
            'description' => 'Experience a serene sunset camel ride through the desert surrounding Cairo, with scenic views of the Giza Pyramids from afar.',
            'location' => 'Desert Cliffs, Cairo',
            'duration' => '3 Hours',
            'price' => 800,
            'image' => '/images/destinations/aswan/camel.png',
            'rating' => 4.7,
            'includes' => ['Camel ride guided tour', 'Traditional tea at desert camp', 'Panoramic pyramid photography stop', 'Hotel pick-up'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Sakkara Desert & Palm Groves ATV Ride',
            'description' => 'Ride an ATV across the desert dunes of Sakkara and speed through the lush palm groves surrounding the ancient Step Pyramid.',
            'location' => 'Sakkara Desert, Cairo',
            'duration' => '5 Hours',
            'price' => 1100,
            'image' => '/images/safaris/hurghada-quad.jpg',
            'rating' => 4.6,
            'includes' => ['ATV rental and safety briefing', 'Desert & palm groves guided trail', 'Entry to Sakkara desert area', 'Refreshing soft drinks'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 7. Taba
        [
            'title' => 'Colored Canyon & Nuweiba Explorer',
            'description' => 'Walk through the multicolored sandstone labyrinth of the Colored Canyon, a breathtaking natural wonder formed over millions of years.',
            'location' => 'Nuweiba / Taba, Sinai',
            'duration' => '1 Day',
            'price' => 3000,
            'image' => '/images/safaris/hurghada-quad.jpg',
            'rating' => 4.8,
            'includes' => ['4x4 transport', 'Bedouin guide', 'Canyon entry permit', 'Lunch at beach camp', 'Bottled water'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Castle Zaman & Fjord Bay Desert Trail',
            'description' => 'Embark on a desert trek around the spectacular Fjord Bay near Taba, followed by a slow-cooked mountain lunch at Castle Zaman.',
            'location' => 'Fjord Bay, Taba',
            'duration' => '8 Hours',
            'price' => 2500,
            'image' => '/images/safaris/siwa-adventure.jpg',
            'rating' => 4.7,
            'includes' => ['Fjord Bay guided hike', 'Castle Zaman pool & facility access', 'Gourmet slow-cooked lunch', 'Roundtrip transfer'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Taba Heights Canyon Hiking Expedition',
            'description' => 'Discover the magnificent hidden limestone canyons and natural rock pools of the Taba Heights desert region.',
            'location' => 'Taba Heights, Taba',
            'duration' => '6 Hours',
            'price' => 1800,
            'image' => '/images/safaris/bahariya-oasis.jpg',
            'rating' => 4.6,
            'includes' => ['Mountain rescue trained guide', 'Hiking poles and gear', 'Oasis snack basket', 'National park entry fee'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 8. Aswan
        [
            'title' => 'Aswan Nubian Village Camel Safari',
            'description' => 'A scenic camel ride across Aswan\'s golden sands and along the Nile to the colorful Nubian Village and St. Simeon Monastery.',
            'location' => 'Aswan',
            'duration' => '3 Hours',
            'price' => 1000,
            'image' => '/images/destinations/aswan/camel.png',
            'rating' => 4.7,
            'includes' => ['Camel ride fee', 'Local Nubian guide', 'Village tour & home visit', 'Traditional Nubian tea', 'Rest stop'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Tombs of the Nobles Desert Trek',
            'description' => 'Hike across the Aswan desert cliffs to visit the ancient rock-cut Tombs of the Nobles, enjoying panoramic Nile views.',
            'location' => 'Nobles Desert, Aswan',
            'duration' => '4 Hours',
            'price' => 600,
            'image' => '/images/safaris/bahariya-oasis.jpg',
            'rating' => 4.6,
            'includes' => ['Certified Egyptologist guide', 'Tomb entry tickets', 'Boat crossing to West Bank', 'Bottled water'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Philae Island Sunset Felucca & Desert Walk',
            'description' => 'Sail on a traditional Felucca boat to Philae and enjoy a peaceful walk along the desert banks of the Nile at sunset.',
            'location' => 'Philae Banks, Aswan',
            'duration' => '5 Hours',
            'price' => 900,
            'image' => '/images/safaris/wadi-el-rayan.jpg',
            'rating' => 4.8,
            'includes' => ['Private Felucca boat hire', 'Guided desert island walk', 'Traditional Nubian snacks & tea', 'Hotel transfers'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 9. Marsa Alam
        [
            'title' => 'Wadi El Gemal National Park Safari',
            'description' => '4x4 safari in the "Valley of the Camels" to observe wild gazelles, historical Roman ruins, and snorkel in pristine Red Sea bays.',
            'location' => 'Marsa Alam, Red Sea',
            'duration' => '1 Day',
            'price' => 4000,
            'image' => '/images/safaris/siwa-adventure.jpg',
            'rating' => 4.9,
            'includes' => ['4x4 safari cruiser', 'National Park entry fee', 'Traditional Bedouin lunch', 'Snorkeling gear rental', 'Wildlife guide'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Red Sea Desert Quad Biking & Camel Ride',
            'description' => 'Embark on a high-speed quad bike adventure across Marsa Alam\'s desert plains followed by a traditional camel ride.',
            'location' => 'Red Sea Desert, Marsa Alam',
            'duration' => '4 Hours',
            'price' => 1200,
            'image' => '/images/safaris/hurghada-quad.jpg',
            'rating' => 4.7,
            'includes' => ['Quad bike rental', 'Camel riding experience', 'Local Bedouin guide', 'Soft drinks and hotel pickup'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Shalateen Camel Market Explorer',
            'description' => 'Embark on a desert road trip to Shalateen near Marsa Alam to experience the largest traditional camel market in Egypt.',
            'location' => 'Shalateen Desert, Marsa Alam',
            'duration' => '1 Day',
            'price' => 3500,
            'image' => '/images/destinations/aswan/camel.png',
            'rating' => 4.6,
            'includes' => ['Comfortable tour transport', 'Local cultural guide', 'Traditional lunch', 'Security permits and entry fees'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 10. Giza
        [
            'title' => 'Giza Pyramids Quad Bike & Camel Desert Tour',
            'description' => 'An epic adventure combining quad biking and camel riding at the base of the Great Pyramids of Giza during sunset.',
            'location' => 'Giza Pyramids Desert, Giza',
            'duration' => '4 Hours',
            'price' => 1200,
            'image' => '/images/safaris/bahariya-oasis.jpg',
            'rating' => 4.8,
            'includes' => ['Quad bike rental', 'Camel riding experience', 'Professional tour guide', 'Bottled water and soft drinks', 'Hotel transfers'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Great Sphinx Sunset Horseback Ride',
            'description' => 'Ride a beautiful Arabian horse through the Giza desert, watching the sun sink behind the Sphinx and Pyramids.',
            'location' => 'Sphinx Desert, Giza',
            'duration' => '2 Hours',
            'price' => 800,
            'image' => '/images/safaris/siwa-adventure.jpg',
            'rating' => 4.9,
            'includes' => ['Arabian horse rental', 'Professional equestrian guide', 'Desert tea at sunset camp', 'Hotel pickup & drop-off'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Dahshur & Saqqara Desert 4x4 Expedition',
            'description' => 'A full-day 4x4 desert safari connecting the Step Pyramid of Saqqara with the Bent and Red Pyramids of Dahshur.',
            'location' => 'Dahshur Dunes, Giza',
            'duration' => '8 Hours',
            'price' => 2000,
            'image' => '/images/safaris/wadi-el-rayan.jpg',
            'rating' => 4.7,
            'includes' => ['4x4 Land Cruiser transport', 'Certified Egyptologist guide', 'Traditional lunch at countryside farm', 'Pyramids area entry tickets'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 11. Alexandria
        [
            'title' => 'Alexandria Coastal Desert & El Alamein Safari',
            'description' => 'Explore the rugged coastal desert landscapes and historic battlefields of El Alamein near Alexandria in a 4x4 cruiser.',
            'location' => 'El Alamein Desert, Alexandria',
            'duration' => '1 Day',
            'price' => 2800,
            'image' => '/images/safaris/siwa-adventure.jpg',
            'rating' => 4.7,
            'includes' => ['4x4 Land Cruiser transport', 'Historical site entry fees', 'Mediterranean seafood lunch', 'English-speaking guide'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'King Mariout Desert Oasis 4x4 Tour',
            'description' => 'Venture into the King Mariout desert dunes near Alexandria, discovering hidden oasis lakes and ancient ruins.',
            'location' => 'King Mariout, Alexandria',
            'duration' => '6 Hours',
            'price' => 1500,
            'image' => '/images/safaris/bahariya-oasis.jpg',
            'rating' => 4.5,
            'includes' => ['4x4 Land Cruiser transport', 'Desert oasis picnic', 'Local guide and driver', 'Cold beverages'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Borg El Arab Sand Dunes & Campfire',
            'description' => 'Drive through the rolling sand dunes of Borg El Arab and enjoy a cozy desert campfire with traditional music and grill.',
            'location' => 'Borg El Arab Dunes, Alexandria',
            'duration' => '8 Hours',
            'price' => 1800,
            'image' => '/images/safaris/white-desert.jpg',
            'rating' => 4.6,
            'includes' => ['4x4 dune transport', 'Campfire barbecue dinner', 'Live acoustic music show', 'Alexandria city pickup'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 12. Luxor
        [
            'title' => 'Luxor West Bank Desert & Valley Safari',
            'description' => 'Traverse the ancient West Bank desert of Luxor, discovering hidden valley tombs and enjoying a Bedouin dinner under the cliffs.',
            'location' => 'West Bank Desert, Luxor',
            'duration' => '6 Hours',
            'price' => 1600,
            'image' => '/images/safaris/bahariya-oasis.jpg',
            'rating' => 4.9,
            'includes' => ['Camel & Donkey trail rides', 'Private Bedouin campfire dinner', 'Valley tours with certified Egyptologist', 'Hotel pick-up & drop-off'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Valley of the Kings Sunrise Hot Air Balloon & Desert Ride',
            'description' => 'Witness the Valley of the Kings from a hot air balloon at sunrise, followed by a desert camel trek through ancient trails.',
            'location' => 'Valley of Kings, Luxor',
            'duration' => '5 Hours',
            'price' => 3500,
            'image' => '/images/safaris/siwa-adventure.jpg',
            'rating' => 4.9,
            'includes' => ['Hot Air Balloon ticket', 'Camel ride in West Bank desert', 'Light breakfast and drinks', 'All transfers & boat crossing'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Medinet Habu Desert Horseback Trail',
            'description' => 'Ride a horse along the desert border of Medinet Habu temple, experiencing the ancient structures from a unique perspective.',
            'location' => 'Habu Desert, Luxor',
            'duration' => '3 Hours',
            'price' => 900,
            'image' => '/images/safaris/wadi-el-rayan.jpg',
            'rating' => 4.8,
            'includes' => ['Guided horse trek', 'Equestrian helmet and gear', 'Traditional mint tea at local stable', 'Hotel transfers'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 13. Hurghada
        [
            'title' => 'Hurghada Red Sea Desert Super Safari',
            'description' => 'A comprehensive desert adventure featuring quad biking, dune buggy riding, camel trekking, and a traditional Bedouin show.',
            'location' => 'Red Sea Desert, Hurghada',
            'duration' => '7 Hours',
            'price' => 950,
            'image' => '/images/safaris/hurghada-quad.jpg',
            'rating' => 4.8,
            'includes' => ['Quad biking & buggy rides', 'Traditional Bedouin barbecue dinner', 'Oriental show & folklore dance', 'Star-gazing experience'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Sahara Park Buggy & Stargazing',
            'description' => 'Drive a beach buggy deep into Hurghada\'s Sahara Park, visit a Bedouin village, and enjoy night-time telescope stargazing.',
            'location' => 'Sahara Park, Hurghada',
            'duration' => '5 Hours',
            'price' => 700,
            'image' => '/images/safaris/siwa-adventure.jpg',
            'rating' => 4.6,
            'includes' => ['Beach buggy rental', 'Bedouin village tour', 'Sunset photography stops', 'Astronomer guide with telescope'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Makadi Bay Dunes Quad & Beach Trail',
            'description' => 'Ride a quad bike across the towering dunes of Makadi Bay, culminating in a beautiful ride along the sandy coastline.',
            'location' => 'Makadi Bay Desert, Hurghada',
            'duration' => '4 Hours',
            'price' => 1100,
            'image' => '/images/safaris/hurghada-quad.jpg',
            'rating' => 4.7,
            'includes' => ['Quad bike hire & helmet', 'Desert and beach guided trail', 'Snacks and soft drinks', 'Hotel transfers'],
            'difficulty' => 'Medium',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 14. Marsa Matrouh
        [
            'title' => 'Marsa Matrouh Agiba Dunes Safari',
            'description' => 'Ride through the spectacular white sand dunes overlooking the pristine turquoise waters of Agiba beach in Marsa Matrouh.',
            'location' => 'Agiba Beach Dunes, Marsa Matrouh',
            'duration' => '5 Hours',
            'price' => 1100,
            'image' => '/images/safaris/white-desert.jpg',
            'rating' => 4.6,
            'includes' => ['4x4 sand cruiser adventure', 'Sandboarding on white dunes', 'Traditional Bedouin mint tea', 'Fresh seafood lunch by the beach'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Cleopatra Beach Desert Cliffs Hike',
            'description' => 'Embark on a guided hike across the desert cliffs and rock formations of Cleopatra Beach, learning about the local history.',
            'location' => 'Cleopatra Cliffs, Marsa Matrouh',
            'duration' => '3 Hours',
            'price' => 700,
            'image' => '/images/safaris/bahariya-oasis.jpg',
            'rating' => 4.5,
            'includes' => ['Local hiking guide', 'Fresh fruit and snacks', 'Historical commentary', 'Hotel transfers'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'White Valley Sand Cruiser Tour',
            'description' => 'Explore the hidden White Valley in Marsa Matrouh with a specialized sand cruiser, enjoying sand dunes and natural rock carvings.',
            'location' => 'White Valley, Marsa Matrouh',
            'duration' => '6 Hours',
            'price' => 1500,
            'image' => '/images/safaris/white-desert.jpg',
            'rating' => 4.7,
            'includes' => ['Sand cruiser vehicle transport', 'Sandboarding experience', 'Traditional lunch at desert camp', 'Guide and driver'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],

        // 15. Port Said
        [
            'title' => 'Port Said Salt Mountain & Desert Explorer',
            'description' => 'Visit the spectacular snow-like salt mountains of Port Fouad and embark on a desert safari exploring the Suez Canal region.',
            'location' => 'Port Fouad Desert, Port Said',
            'duration' => '6 Hours',
            'price' => 1300,
            'image' => '/images/safaris/wadi-el-rayan.jpg',
            'rating' => 4.5,
            'includes' => ['Salt Mountain photography tour', '4x4 desert safari Cruiser', 'Suez Canal ferry crossing', 'Traditional lunch at Port Said'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Port Fouad Salt Lake ATV & Camp',
            'description' => 'Ride an ATV along the edges of the salt lakes of Port Fouad and relax at a desert camp with fresh coffee.',
            'location' => 'Salt Lakes, Port Said',
            'duration' => '4 Hours',
            'price' => 900,
            'image' => '/images/safaris/hurghada-quad.jpg',
            'rating' => 4.6,
            'includes' => ['ATV rental and safety briefing', 'Desert camp access & hospitality', 'Salt lake bird-watching stops', 'Hotel transfers'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
        [
            'title' => 'Suez Canal Dunes 4x4 Sunset Ride',
            'description' => 'Experience a thrilling 4x4 ride across the coastal sand dunes bordering the Suez Canal, catching the ships passing at sunset.',
            'location' => 'Suez Canal Dunes, Port Said',
            'duration' => '5 Hours',
            'price' => 1600,
            'image' => '/images/safaris/wadi-el-rayan.jpg',
            'rating' => 4.7,
            'includes' => ['4x4 Land Cruiser transport', 'Sunset photography stops', 'Traditional Port Said snacks & drinks', 'Roundtrip transfer'],
            'difficulty' => 'Easy',
            'status' => 'approved',
            'available_count' => 50,
        ],
    ];

    foreach ($data as $item) {
        \App\Models\Safari::create($item);
    }

    return response()->json(['status' => 'Safaris re-seeded ✅', 'count' => \App\Models\Safari::count()]);
});

Route::get('/events-reseed', function () {
    \App\Models\Event::truncate();
    app(\App\Http\Controllers\EventController::class)->index(); // triggers auto-seed
    return response()->json(['status' => 'Events re-seeded ✅', 'count' => \App\Models\Event::count()]);
});

Route::get('/restaurants-reseed', function () {
    $seeder = new \Database\Seeders\NewRestaurantSeeder();
    $seeder->run();
    return response()->json(['status' => 'Restaurants re-seeded ✅', 'count' => \App\Models\Restaurant::count()]);
});

Route::get('/emergency-services', [EmergencyServiceController::class, 'index']);
Route::get('/emergency-services-reseed', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate');
        \App\Models\EmergencyService::truncate();
        $seeder = new \Database\Seeders\EmergencyServiceSeeder();
        $seeder->run();
        return response()->json(['status' => 'Migrations run & Emergency services re-seeded ✅', 'count' => \App\Models\EmergencyService::count()]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/home', [HomeController::class, 'index']);

// Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„ÙÙ†Ø§Ø¯Ù‚
Route::get('/hotels', [HotelController::class, 'index']);
Route::get('/hotels/{id}', [HotelController::class, 'show']);
Route::get('/hotels/{id}/rooms', [HotelController::class, 'rooms']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/social-login', [AuthController::class, 'socialLogin']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/profile/update', [AuthController::class, 'updateProfile']);
    });
});

Route::get('/flights/{flightId}/occupied-seats', [BookingController::class, 'occupiedSeatsForFlight']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

    // Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø·Ù„Ø¨Ø§Øª Ù„Ù„Ù…ØªØ¬Ø±
    Route::get('/orders/my-orders', [OrderController::class, 'userOrders']);
    Route::post('/orders', [OrderController::class, 'store']);
    // Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø´Ø§Øª Ø¨ÙˆØª Ø§Ù„Ù…Ø®ØµØµØ© Ù„Ù„Ø­Ø³Ø§Ø¨Ø§Øª
    Route::post('/chat/auth', [App\Http\Controllers\KemetChatbotController::class, 'askAuth']);

    // Ù…Ø³Ø§Ø±Ø§Øª Ø¥Ø¶Ø§ÙØ© Ø§Ù„ØªÙ‚ÙŠÙŠÙ…Ø§Øª
    Route::post('/reviews/{item_type}/{item_id}', [ReviewController::class, 'store']);
});

// Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„ÙˆØ¬Ù‡Ø§Øª Ø§Ù„Ø³ÙŠØ§Ø­ÙŠØ© (ÙÙ†Ø§Ø¯Ù‚ØŒ Ù…Ø·Ø§Ø¹Ù…ØŒ Ù…ØªØ§Ø­Ù...)
Route::get('/destinations', [DestinationController::class, 'index']);
// Checkout OTP Routes
Route::post('/checkout/send-otp', [PaymentController::class, 'sendCheckoutOTP']);
Route::post('/checkout/verify-otp', [PaymentController::class, 'verifyCheckoutOTP']);
Route::get('/destinations/search', [DestinationController::class, 'search']);

// ==========================================
// Support & Newsletter Routes
// ==========================================

Route::post('/support/contact', [SupportController::class, 'contact']);
Route::post('/newsletter/subscribe', [SupportController::class, 'subscribe']);

Route::get('/destinations/{id}', [DestinationController::class, 'show']);
Route::post('/destinations', [DestinationController::class, 'store']); // ÙŠØ³ØªØ­Ø³Ù† Ù„Ø§Ø­Ù‚Ø§Ù‹ Ø­Ù…Ø§ÙŠØªÙ‡Ø§ Ø¨Ø­Ø³Ø§Ø¨ Ø§Ù„Ù…Ø¯ÙŠØ±

// Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø±Ø­Ù„Ø§Øª ÙˆØ§Ù„Ø¨Ø§Ù‚Ø§Øª
Route::get('/tours', [TourController::class, 'index']);
Route::get('/tours/{id}', [TourController::class, 'show']);
Route::post('/tours', [TourController::class, 'store']);

// Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø£Ù†Ø´Ø·Ø© (Popular Things To Do)
Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/activities/{id}', [ActivityController::class, 'show']);

// Ù…Ø³Ø§Ø±Ø§Øª Ù…ØªØ¬Ø± Ø§Ù„Ù‡Ø¯Ø§ÙŠØ§ ÙˆØ§Ù„Ù…Ù†ØªØ¬Ø§Øª (E-Commerce)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Ù…Ø³Ø§Ø±Ø§Øª Ø§Ø³ØªØ±Ø¬Ø§Ø¹ Ø§Ù„ØªÙ‚ÙŠÙŠÙ…Ø§Øª Ù„Ù„Ø¬Ù…Ù‡ÙˆØ±
Route::get('/reviews', [ReviewController::class, 'allReviews']);
Route::get('/reviews/{item_type}/{item_id}', [ReviewController::class, 'index']);

// Ù…Ø³Ø§Ø± Ø§Ù„Ø´Ø§Øª Ø¨ÙˆØª Ø§Ù„Ø­Ù‚ÙŠÙ‚ÙŠ Ø§Ù„Ù…Ø¯Ø¹ÙˆÙ… Ø¨Ø§Ù„Ø°ÙƒØ§Ø¡ Ø§Ù„Ø§ØµØ·Ù†Ø§Ø¹ÙŠ (Gemini / Groq LLM)
Route::post('/chat', [App\Http\Controllers\KemetChatbotController::class, 'ask']);
Route::get('/chat/history', [App\Http\Controllers\KemetChatbotController::class, 'history']);
Route::post('/vision/analyze', [VisionController::class, 'analyze']);

Route::get('/all-data', function () {
    return [
        'hotels' => \Schema::hasTable('hotels') ? \App\Models\Hotel::all() : [],
        'restaurants' => \Schema::hasTable('restaurants') ? \DB::table('restaurants')->get() : [],
        'safaris' => \Schema::hasTable('safaris') ? \DB::table('safaris')->get() : [],
        'bazaars' => \Schema::hasTable('bazaars') ? \DB::table('bazaars')->get() : [],
        'events' => \Schema::hasTable('events') ? \DB::table('events')->get() : [],
        'museums' => \Schema::hasTable('museums') ? \DB::table('museums')->get() : [],
        'tours' => \Schema::hasTable('tours') ? \DB::table('tours')->get() : [],
    ];
});

// ===== Ø¨ÙŠØ§Ù†Ø§Øª Ø§Ù„Ø´Ø§Øª Ø¨ÙˆØª Ø§Ù„Ø­ÙŠØ© Ù…Ù† Ø§Ù„Ø¯Ø§ØªØ§ Ø¨ÙŠØ² =====
Route::get('/chatbot-context', [KemetChatbotController::class, 'getContext']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ù…Ø¯ÙˆÙ†Ø© ÙˆØ§Ù„Ù…Ù‚Ø§Ù„Ø§Øª (Blogs / Travel Guides) =====
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø¹Ø±ÙˆØ¶ ÙˆØ§Ù„ØµÙÙ‚Ø§Øª (Deals) =====
Route::get('/deals', [DealController::class, 'index']);
Route::get('/deals/{id}', [DealController::class, 'show']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø¨Ø§Ù‚Ø§Øª Ø§Ù„Ø³ÙŠØ§Ø­ÙŠØ© (Travel Packages) =====
Route::get('/travelpackages', [TravelPackageController::class, 'index']);
Route::get('/travelpackages/{id}', [TravelPackageController::class, 'show']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø¨Ø­Ø« (Global Search) =====
Route::get('/search', [SearchController::class, 'search']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ù…Ø®Ø·Ø· Ø§Ù„Ø±Ø­Ù„Ø§Øª Ø¨Ø§Ù„Ø°ÙƒØ§Ø¡ Ø§Ù„Ø§ØµØ·Ù†Ø§Ø¹ÙŠ (AI Trip Planner) =====
Route::post('/trip-planner/generate', [TripPlannerController::class, 'generateTrip']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ù…Ø·Ø§Ø¹Ù… (Restaurants) =====
Route::get('/restaurants', [RestaurantController::class, 'index']);
Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø£Ø­Ø¯Ø§Ø« ÙˆØ§Ù„ÙØ¹Ø§Ù„ÙŠØ§Øª (Events) =====
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ù…ØªØ§Ø­Ù ÙˆØ§Ù„Ù…Ø¹Ø§Ù„Ù… (Museums & Landmarks) =====
Route::get('/museums', [MuseumController::class, 'index']);
Route::get('/museums/{id}', [MuseumController::class, 'show']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø£Ø³ÙˆØ§Ù‚ ÙˆØ§Ù„ØªØ³ÙˆÙ‚ (Bazaars & Shopping) =====
Route::get('/bazaars', [BazaarController::class, 'index']);
Route::get('/bazaars/{id}', [BazaarController::class, 'show']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø³ÙØ§Ø±ÙŠ ÙˆØ§Ù„ØµØ­Ø±Ø§Ø¡ (Safaris) =====
Route::get('/safaris', [SafariController::class, 'index']);
Route::get('/safaris/{id}', [SafariController::class, 'show']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ù…ÙˆØ§ØµÙ„Ø§Øª (Transportation) =====
Route::get('/transportation', [TransportationController::class, 'index']);
Route::get('/transportation/{id}', [TransportationController::class, 'show']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ù…Ø­ØªÙˆÙ‰ Ø§Ù„Ø«Ø§Ø¨Øª (CMS Content & FAQs) =====
Route::get('/content/pages/{slug}', [ContentController::class, 'getPage']);
Route::get('/content/faqs', [ContentController::class, 'getFaqs']);
Route::get('/content/hero-slides', [ContentController::class, 'getHeroSlides']);
Route::get('/content/nav-items', [ContentController::class, 'getNavItems']);
Route::get('/content/why-choose-us', [ContentController::class, 'getWhyChooseUs']);
Route::get('/content/footer', [ContentController::class, 'getFooterData']);
Route::get('/content/attractions', [AttractionController::class, 'index']);
Route::get('/content/attractions/{slug}', [AttractionController::class, 'show']);
Route::get('/content/home-marquee', [ContentController::class, 'getHomeMarquee']);
Route::get('/content/activity-filters', [ContentController::class, 'getActivityFilters']);

// ===== Arab World Tourism Routes =====
Route::get('/arab-world/countries', [ArabWorldController::class, 'getCountries']);
Route::get('/arab-world/landmarks', [ArabWorldController::class, 'getLandmarks']);
Route::get('/arab-world-reseed', [ArabWorldController::class, 'reseed']);

// ===== Hajj & Umrah Routes =====
Route::get('/hajj-umrah/packages', [\App\Http\Controllers\HajjUmrahController::class, 'getPackages']);
Route::get('/hajj-umrah-reseed', [\App\Http\Controllers\HajjUmrahController::class, 'reseed']);

// ===== مسارات الدعم والتواصل (Support & Newsletter) =====
Route::post('/support/contact', [SupportController::class, 'contact']);
Route::post('/newsletter/subscribe', [SupportController::class, 'subscribe']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø¯Ù Ø¹ (Payments) =====
Route::post('/payment/process', [PaymentController::class, 'process']);
Route::get('/payment/status/{transactionId}', [PaymentController::class, 'status']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ù…Ø­Ù…ÙŠØ© (Wishlist & Notifications) - ØªØ­ØªØ§Ø¬ ØªØ³Ø¬ÙŠÙ„ Ø¯Ø®ÙˆÙ„ =====
Route::middleware('auth:sanctum')->group(function () {
    // Ø§Ù„Ù…ÙØ¶Ù„Ø© (Wishlist)
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);

    // Ø§Ù„Ø¥Ø´Ø¹Ø§Ø±Ø§Øª (Notifications)
    Route::get('/user/notifications', [NotificationController::class, 'index']);
    Route::put('/user/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/user/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

    // Ø§Ù„Ø³Ù„Ø© (Cart)
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{productId}', [CartController::class, 'destroy']);
    Route::delete('/cart', [CartController::class, 'clear']);
    // Checkout OTP routes
    Route::post('/checkout/send-otp', [PaymentController::class, 'sendCheckoutOTP']);
    Route::post('/checkout/verify-otp', [PaymentController::class, 'verifyCheckoutOTP']);
});





// ===== Restore ALL original images =====
Route::get('/restore-original-images', function () {
    $updated = [];

    // ─── TOURS: Restore original seeder images ────────────────────────────────
    $tourKeywords = [
        'Pyramids'        => '/images/tour-pyramids.png',
        'Cairo City'      => '/images/tour-pyramids.png',
        'Nile Dinner'     => '/images/tour-nile-cruise.png',
        'Nile Cruise'     => '/images/tour-nile-cruise.png',
        'Felucca'         => '/images/tour-nile-cruise.png',
        'Red Sea Snorkel' => '/images/tour-red-sea.png',
        'Red Sea'         => '/images/tour-red-sea.png',
        'Desert Safari'   => '/images/tour-desert-safari.png',
        'ATV'             => '/images/tour-desert-safari.png',
        'Cairo Food'      => '/images/tour-cairo-food.png',
        'Food Tour'       => '/images/tour-cairo-food.png',
        'Museum'          => '/images/tour-museum.png',
        'Valley of'       => '/images/tour-pyramids.png',
        'Luxor'           => '/images/tour-pyramids.png',
        'Aswan'           => '/images/tour-nile-cruise.png',
        'Nubian'          => '/images/tour-nile-cruise.png',
    ];
    $tourFallbacks = [
        '/images/tour-pyramids.png',
        '/images/tour-nile-cruise.png',
        '/images/tour-red-sea.png',
        '/images/tour-desert-safari.png',
        '/images/tour-cairo-food.png',
        '/images/tour-museum.png',
    ];
    $tc = 0;
    \App\Models\Tour::chunk(100, function ($tours) use ($tourKeywords, $tourFallbacks, &$tc, &$updated) {
        foreach ($tours as $tour) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $tour */
            $img = null;
            foreach ($tourKeywords as $kw => $path) {
                if (str_contains($tour->title, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $tourFallbacks[$tc % count($tourFallbacks)];
            $tour->update(['image' => $img]);
            $tc++;
        }
        $updated['tours'] = $tc;
    });

    // ─── SAFARIS: Restore original images ────────────────────────────────────
    $safariKeywords = [
        'Bahariya'      => '/images/safaris/bahariya-oasis.jpg',
        'White Desert'  => '/images/safaris/white-desert.jpg',
        'Siwa'          => '/images/safaris/siwa-adventure.jpg',
        'Wadi El Rayan' => '/images/safaris/wadi-el-rayan.jpg',
        'Wadi'          => '/images/safaris/wadi-el-rayan.jpg',
        'Hurghada'      => '/images/safaris/hurghada-quad.jpg',
        'ATV'           => '/images/safaris/hurghada-quad.jpg',
        'Quad'          => '/images/safaris/hurghada-quad.jpg',
        'Red Sea'       => '/images/safaris/hurghada-quad.jpg',
        'Giza'          => '/images/safaris/bahariya-oasis.jpg',
        'Saqqara'       => '/images/safaris/bahariya-oasis.jpg',
        'Bedouin'       => '/images/safaris/siwa-adventure.jpg',
        'Fayoum'        => '/images/safaris/wadi-el-rayan.jpg',
    ];
    $safariFallbacks = [
        '/images/safaris/bahariya-oasis.jpg',
        '/images/safaris/hurghada-quad.jpg',
        '/images/safaris/siwa-adventure.jpg',
        '/images/safaris/wadi-el-rayan.jpg',
        '/images/safaris/white-desert.jpg',
    ];
    $sc = 0;
    \App\Models\Safari::chunk(100, function ($safaris) use ($safariKeywords, $safariFallbacks, &$sc, &$updated) {
        foreach ($safaris as $safari) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $safari */
            $img = null;
            $titleLc = $safari->title . ' ' . $safari->location;
            foreach ($safariKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $safariFallbacks[$sc % count($safariFallbacks)];
            $safari->update(['image' => $img]);
            $sc++;
        }
        $updated['safaris'] = $sc;
    });

    // ─── MUSEUMS: Restore original images ────────────────────────────────────
    $museumKeywords = [
        'Karnak'           => '/museums/karnak_hero.png',
        'Luxor Museum'     => '/museums/luxor_1.png',
        'Kom Ombo'         => '/museums/kom_1.png',
        'National Museum'  => '/museums/nmec_1.jpg',
        'NMEC'             => '/museums/nmec_1.jpg',
        'Grand Egyptian'   => '/images/destinations/giza/gem.png',
        'GEM'              => '/images/destinations/giza/gem.png',
        'Imhotep'          => '/images/destinations/giza/imhotep.png',
        'Nubian Museum'    => '/images/destinations/aswan/nubian_museum.png',
        'Elephantine'      => '/images/destinations/aswan/elephantine_museum.png',
        'Montaza'          => '/museums/montaza_1.png',
        'Islamic'          => '/images/home/museums.jpg',
        'Coptic'           => '/images/home/museums.jpg',
        'Egyptian Museum'  => '/museums/nmec_1.jpg',
    ];
    $museumFallbacks = [
        '/museums/karnak_hero.png',
        '/museums/nmec_1.jpg',
        '/museums/montaza_1.png',
        '/museums/kom_1.png',
        '/images/home/museums.jpg',
    ];
    $mc = 0;
    \App\Models\Museum::chunk(100, function ($museums) use ($museumKeywords, $museumFallbacks, &$mc, &$updated) {
        foreach ($museums as $museum) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $museum */
            $img = null;
            $titleLc = ($museum->name ?? '') . ' ' . ($museum->location ?? '');
            foreach ($museumKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $museumFallbacks[$mc % count($museumFallbacks)];
            $museum->update(['image' => $img]);
            $mc++;
        }
        $updated['museums'] = $mc;
    });

    // ─── EVENTS: Restore original images ─────────────────────────────────────
    $eventKeywords = [
        'Book Fair'         => '/events/event_book_fair.png',
        'Cairo Jazz'        => '/events/event_cairo_jazz.png',
        'Jazz'              => '/events/event_cairo_jazz.png',
        'Opera'             => '/events/event_opera_aida.png',
        'Aida'              => '/events/event_opera_aida.png',
        'Pyramids'          => '/events/event_pyramids_light_show.png',
        'Sound'             => '/events/event_pyramids_light_show.png',
        'Light Show'        => '/events/event_pyramids_light_show.png',
        'EDM'               => '/events/event_red_sea_edm.png',
        'Red Sea'           => '/events/event_red_sea_edm.png',
        'Hurghada'          => '/events/event_red_sea_edm.png',
        'Gouna'             => '/events/event_red_sea_edm.png',
        'Film'              => '/events/event_red_sea_edm.png',
        'Whirling'          => '/events/event_whirling_dervishes.png',
        'Dervish'           => '/events/event_whirling_dervishes.png',
        'Pottery'           => '/images/bazaars/spices.png',
        'Tunis'             => '/images/bazaars/spices.png',
        'Fayoum'            => '/images/bazaars/spices.png',
    ];
    $eventFallbacks = [
        '/events/event_book_fair.png',
        '/events/event_cairo_jazz.png',
        '/events/event_opera_aida.png',
        '/events/event_pyramids_light_show.png',
        '/events/event_red_sea_edm.png',
        '/events/event_whirling_dervishes.png',
    ];
    $ev = 0;
    \App\Models\Event::chunk(100, function ($events) use ($eventKeywords, $eventFallbacks, &$ev, &$updated) {
        foreach ($events as $event) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $event */
            $img = null;
            $titleLc = ($event->title ?? '') . ' ' . ($event->category ?? '');
            foreach ($eventKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $eventFallbacks[$ev % count($eventFallbacks)];
            $event->update(['image' => $img]);
            $ev++;
        }
        $updated['events'] = $ev;
    });

    // ─── BAZAARS: Restore original seeder images ──────────────────────────────
    $bazaarKeywords = [
        'Khan'          => '/images/bazaars/khan-el-khalili.jpg',
        'Khalili'       => '/images/bazaars/khan-el-khalili.jpg',
        'Cairo'         => '/images/bazaars/khan-el-khalili.jpg',
        'Wissa'         => '/images/bazaars/khan-el-khalili.jpg',
        'Nazlet'        => '/images/bazaars/khan-el-khalili.jpg',
        'Giza'          => '/images/bazaars/khan-el-khalili.jpg',
        'Aswan'         => '/images/bazaars/aswan-spice.jpg',
        'Nubian'        => '/images/bazaars/aswan-spice.jpg',
        'Luxor'         => '/images/bazaars/luxor-souq.jpg',
        'Sharm'         => '/images/bazaars/sharm-old-market.jpg',
        'Siwa'          => '/images/bazaars/shali-market.jpg',
        'Shali'         => '/images/bazaars/shali-market.jpg',
        'Mansheya'      => '/images/bazaars/mansheya-market.jpg',
        'Alexandria'    => '/images/bazaars/mansheya-market.jpg',
        'Fayoum'        => '/images/bazaars/luxor-souq.jpg',
        'Tunis'         => '/images/bazaars/luxor-souq.jpg',
        'Hurghada'      => '/images/bazaars/aswan-spice.jpg',
    ];
    $bazaarFallbacks = [
        '/images/bazaars/khan-el-khalili.jpg',
        '/images/bazaars/aswan-spice.jpg',
        '/images/bazaars/luxor-souq.jpg',
        '/images/bazaars/sharm-old-market.jpg',
        '/images/bazaars/shali-market.jpg',
        '/images/bazaars/mansheya-market.jpg',
    ];
    $bz = 0;
    \App\Models\Bazaar::chunk(100, function ($bazaars) use ($bazaarKeywords, $bazaarFallbacks, &$bz, &$updated) {
        foreach ($bazaars as $bazaar) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $bazaar */
            $img = null;
            $titleLc = ($bazaar->title ?? '') . ' ' . ($bazaar->location ?? '');
            foreach ($bazaarKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $bazaarFallbacks[$bz % count($bazaarFallbacks)];
            $bazaar->update(['image' => $img]);
            $bz++;
        }
        $updated['bazaars'] = $bz;
    });

    // ─── HOTELS: Restore original location-based images ──────────────────────
    $hotelByLoc = [
        'cairo'      => ['/images/hotels/cairo.png', '/hotels/pyramids.png', '/hotels/cairo_boutique.png', '/hotels/cairo_heritage.png'],
        'giza'       => ['/images/hotels/giza.png', '/hotels/pyramids.png', '/hotels/nile.png'],
        'sharm'      => ['/hotels/redsea.png', '/hotels/sharm_bungalows.png'],
        'hurghada'   => ['/hotels/redsea.png', '/hotels/marsa_lodge.png'],
        'marsa'      => ['/hotels/redsea.png', '/hotels/marsa_lodge.png'],
        'luxor'      => ['/hotels/luxor.png', '/hotels/luxor_sunset.png'],
        'aswan'      => ['/hotels/aswan.png', '/hotels/aswan_cruise.png'],
        'siwa'       => ['/hotels/siwa.png'],
        'fayoum'     => ['/images/hotels/fayoum.png', '/hotels/siwa.png'],
        'alexandria' => ['/hotels/alex.png', '/hotels/north_coast.png'],
        'alex'       => ['/hotels/alex.png'],
        'matrouh'    => ['/hotels/matrouh.png', '/hotels/north_coast.png'],
        'dahab'      => ['/hotels/redsea.png'],
        'taba'       => ['/hotels/redsea.png'],
        'said'       => ['/hotels/nile.png'],
    ];
    $allHotelImgs = [
        '/hotels/pyramids.png', '/hotels/nile.png', '/hotels/redsea.png',
        '/hotels/luxor.png', '/hotels/siwa.png', '/hotels/aswan.png',
        '/hotels/alex.png', '/hotels/cairo_boutique.png', '/hotels/matrouh.png',
        '/hotels/desert.png', '/hotels/luxor_sunset.png', '/hotels/sharm_bungalows.png',
        '/hotels/cairo_heritage.png', '/hotels/aswan_cruise.png', '/hotels/marsa_lodge.png',
        '/hotels/north_coast.png',
    ];
    $hc = 0;
    \App\Models\Hotel::chunk(100, function ($hotels) use ($hotelByLoc, $allHotelImgs, &$hc, &$updated) {
        foreach ($hotels as $hotel) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $hotel */
            $loc = strtolower($hotel->location ?? '');
            $pool = null;
            foreach ($hotelByLoc as $kw => $paths) {
                if (str_contains($loc, $kw)) { $pool = $paths; break; }
            }
            if (!$pool) $pool = [$allHotelImgs[$hc % count($allHotelImgs)]];
            $img = $pool[$hc % count($pool)];
            $others = array_values(array_filter($allHotelImgs, fn($p) => $p !== $img));
            shuffle($others);
            $hotel->update([
                'image'   => $img,
                'gallery' => array_merge([$img], array_slice($others, 0, 3)),
            ]);
            $hc++;
        }
        $updated['hotels'] = $hc;
    });

    return response()->json(['status' => 'restored ✅', 'updated' => $updated]);
});

// ===== Fix ALL images across the entire platform =====
Route::get('/fix-all-images', function () {
    $updated = [];

    // â”€â”€â”€ TOURS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $tourKeywords = [
        'pyramids'       => '/images/tours/pyramids_giza.png',
        'giza'           => '/images/tours/pyramids_giza.png',
        'nile'           => '/images/tours/nile_cruise.png',
        'felucca'        => '/images/tours/nile_cruise.png',
        'luxor'          => '/images/tours/luxor_valley_kings.png',
        'valley'         => '/images/tours/luxor_valley_kings.png',
        'karnak'         => '/images/tours/luxor_valley_kings.png',
        'hatshepsut'     => '/images/tours/luxor_valley_kings.png',
        'abu simbel'     => '/images/tours/abu_simbel.png',
        'red sea'        => '/images/tours/red_sea_diving.png',
        'diving'         => '/images/tours/red_sea_diving.png',
        'snorkel'        => '/images/tours/red_sea_diving.png',
        'sharm'          => '/images/tours/red_sea_diving.png',
        'hurghada'       => '/images/tours/red_sea_diving.png',
        'aswan'          => '/images/tours/nile_cruise.png',
        'nubian'         => '/images/tours/nile_cruise.png',
        'food'           => '/images/tour-cairo-food.png',
        'cairo food'     => '/images/tour-cairo-food.png',
        'museum'         => '/images/tour-museum.png',
    ];
    $tourFallbacks = array_values(array_unique(array_values($tourKeywords)));
    $tc = 0;
    \App\Models\Tour::chunk(100, function ($tours) use ($tourKeywords, $tourFallbacks, &$tc, &$updated) {
        foreach ($tours as $tour) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $tour */
            $titleLc = strtolower($tour->title . ' ' . $tour->location);
            $img = null;
            foreach ($tourKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $tourFallbacks[$tc % count($tourFallbacks)];
            $tour->update(['image' => $img]);
            $tc++;
        }
        $updated['tours'] = $tc;
    });

    // â”€â”€â”€ SAFARIS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $safariKeywords = [
        'white desert'  => '/images/safaris2/white_desert.png',
        'bahariya'      => '/images/safaris2/bahariya_oasis.png',
        'siwa'          => '/images/safaris2/siwa_oasis.png',
        'wadi'          => '/images/safaris2/wadi_rayan.png',
        'fayoum'        => '/images/safaris2/wadi_rayan.png',
        'hurghada'      => '/images/safaris2/hurghada_atv.png',
        'atv'           => '/images/safaris2/hurghada_atv.png',
        'quad'          => '/images/safaris2/hurghada_atv.png',
        'red sea'       => '/images/safaris2/hurghada_atv.png',
        'bedouin'       => '/images/safaris2/siwa_oasis.png',
        'giza'          => '/images/safaris2/bahariya_oasis.png',
        'saqqara'       => '/images/safaris2/bahariya_oasis.png',
        'horse'         => '/images/safaris2/bahariya_oasis.png',
        'camel'         => '/images/safaris2/siwa_oasis.png',
        'aswan'         => '/images/safaris2/siwa_oasis.png',
    ];
    $safariFallbacks = array_values(array_unique(array_values($safariKeywords)));
    $sc = 0;
    \App\Models\Safari::chunk(100, function ($safaris) use ($safariKeywords, $safariFallbacks, &$sc, &$updated) {
        foreach ($safaris as $safari) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $safari */
            $titleLc = strtolower($safari->title . ' ' . $safari->location);
            $img = null;
            foreach ($safariKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $safariFallbacks[$sc % count($safariFallbacks)];
            $safari->update(['image' => $img]);
            $sc++;
        }
        $updated['safaris'] = $sc;
    });

    // â”€â”€â”€ MUSEUMS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $museumKeywords = [
        'karnak'          => '/images/museums2/karnak_temple.png',
        'luxor temple'    => '/images/museums2/karnak_temple.png',
        'luxor'           => '/images/museums2/karnak_temple.png',
        'grand egyptian'  => '/images/museums2/gem_giza.png',
        'gem'             => '/images/museums2/gem_giza.png',
        'imhotep'         => '/images/museums2/gem_giza.png',
        'egyptian museum' => '/images/museums2/gem_giza.png',
        'giza'            => '/images/museums2/gem_giza.png',
        'nubian'          => '/images/museums2/nubian_museum.png',
        'elephantine'     => '/images/museums2/nubian_museum.png',
        'aswan'           => '/images/museums2/nubian_museum.png',
        'islamic'         => '/images/museums2/islamic_art.png',
        'coptic'          => '/images/museums2/islamic_art.png',
        'cairo'           => '/images/museums2/islamic_art.png',
        'montaza'         => '/images/museums2/montaza_palace.png',
        'alexandria'      => '/images/museums2/montaza_palace.png',
    ];
    $museumFallbacks = array_values(array_unique(array_values($museumKeywords)));
    $mc = 0;
    \App\Models\Museum::chunk(100, function ($museums) use ($museumKeywords, $museumFallbacks, &$mc, &$updated) {
        foreach ($museums as $museum) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $museum */
            $titleLc = strtolower(($museum->name ?? '') . ' ' . ($museum->location ?? ''));
            $img = null;
            foreach ($museumKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $museumFallbacks[$mc % count($museumFallbacks)];
            $museum->update(['image' => $img]);
            $mc++;
        }
        $updated['museums'] = $mc;
    });

    // â”€â”€â”€ EVENTS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $eventKeywords = [
        'pyramids'  => '/images/events2/pyramids_film_fest.png',
        'film'      => '/images/events2/pyramids_film_fest.png',
        'cinema'    => '/images/events2/pyramids_film_fest.png',
        'gouna'     => '/images/events2/gouna_film_fest.png',
        'hurghada'  => '/images/events2/gouna_film_fest.png',
        'opera'     => '/images/events2/cairo_opera.png',
        'aida'      => '/images/events2/cairo_opera.png',
        'whirling'  => '/images/events2/cairo_opera.png',
        'dervish'   => '/images/events2/cairo_opera.png',
        'book'      => '/images/events2/cairo_opera.png',
        'jazz'      => '/images/events2/nile_jazz.png',
        'music'     => '/images/events2/nile_jazz.png',
        'nile'      => '/images/events2/nile_jazz.png',
        'pottery'   => '/images/events2/tunis_pottery.png',
        'tunis'     => '/images/events2/tunis_pottery.png',
        'fayoum'    => '/images/events2/tunis_pottery.png',
        'craft'     => '/images/events2/tunis_pottery.png',
    ];
    $eventFallbacks = array_values(array_unique(array_values($eventKeywords)));
    $ev = 0;
    \App\Models\Event::chunk(100, function ($events) use ($eventKeywords, $eventFallbacks, &$ev, &$updated) {
        foreach ($events as $event) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $event */
            $titleLc = strtolower(($event->title ?? '') . ' ' . ($event->location ?? '') . ' ' . ($event->category ?? ''));
            $img = null;
            foreach ($eventKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $eventFallbacks[$ev % count($eventFallbacks)];
            $event->update(['image' => $img]);
            $ev++;
        }
        $updated['events'] = $ev;
    });

    // â”€â”€â”€ BAZAARS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $bazaarKeywords = [
        'aswan'      => '/images/bazaars2/aswan_souk.png',
        'nubian'     => '/images/bazaars2/aswan_souk.png',
        'khan'       => '/images/bazaars2/khan_khalili.png',
        'khalili'    => '/images/bazaars2/khan_khalili.png',
        'cairo'      => '/images/bazaars2/khan_khalili.png',
        'nazlet'     => '/images/bazaars2/khan_khalili.png',
        'wissa'      => '/images/bazaars2/khan_khalili.png',
        'giza'       => '/images/bazaars2/khan_khalili.png',
        'luxor'      => '/images/bazaars2/luxor_souk.png',
        'souk'       => '/images/bazaars2/luxor_souk.png',
        'fayoum'     => '/images/bazaars2/luxor_souk.png',
        'tunis'      => '/images/bazaars2/luxor_souk.png',
        'pottery'    => '/images/bazaars2/luxor_souk.png',
        'sharm'      => '/images/bazaars2/aswan_souk.png',
        'hurghada'   => '/images/bazaars2/aswan_souk.png',
    ];
    $bazaarFallbacks = ['/images/bazaars2/khan_khalili.png', '/images/bazaars2/aswan_souk.png', '/images/bazaars2/luxor_souk.png'];
    $bz = 0;
    \App\Models\Bazaar::chunk(100, function ($bazaars) use ($bazaarKeywords, $bazaarFallbacks, &$bz, &$updated) {
        foreach ($bazaars as $bazaar) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $bazaar */
            $titleLc = strtolower(($bazaar->title ?? '') . ' ' . ($bazaar->location ?? ''));
            $img = null;
            foreach ($bazaarKeywords as $kw => $path) {
                if (str_contains($titleLc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $bazaarFallbacks[$bz % count($bazaarFallbacks)];
            $bazaar->update(['image' => $img]);
            $bz++;
        }
        $updated['bazaars'] = $bz;
    });

    // â”€â”€â”€ HOTELS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    $hotelByLoc = [
        'cairo'      => '/images/hotels2/cairo_nile.png',
        'giza'       => '/images/hotels2/cairo_nile.png',
        'sharm'      => '/images/hotels2/sharm_resort.png',
        'taba'       => '/images/hotels2/sharm_resort.png',
        'dahab'      => '/images/hotels2/sharm_resort.png',
        'hurghada'   => '/images/hotels2/hurghada_resort.png',
        'marsa'      => '/images/hotels2/hurghada_resort.png',
        'luxor'      => '/images/hotels2/luxor_nile.png',
        'aswan'      => '/images/hotels2/aswan_nubian.png',
        'siwa'       => '/images/hotels2/aswan_nubian.png',
        'alexandria' => '/images/hotels2/cairo_nile.png',
        'alex'       => '/images/hotels2/cairo_nile.png',
        'matrouh'    => '/images/hotels2/sharm_resort.png',
        'fayoum'     => '/images/hotels2/luxor_nile.png',
        'said'       => '/images/hotels2/cairo_nile.png',
    ];
    $allHotelImgs = [
        '/images/hotels2/cairo_nile.png',
        '/images/hotels2/sharm_resort.png',
        '/images/hotels2/luxor_nile.png',
        '/images/hotels2/aswan_nubian.png',
        '/images/hotels2/hurghada_resort.png',
    ];
    $hc = 0;
    \App\Models\Hotel::chunk(100, function ($hotels) use ($hotelByLoc, $allHotelImgs, &$hc, &$updated) {
        foreach ($hotels as $hotel) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $hotel */
            $loc = strtolower($hotel->location ?? '');
            $img = null;
            foreach ($hotelByLoc as $kw => $path) {
                if (str_contains($loc, $kw)) { $img = $path; break; }
            }
            if (!$img) $img = $allHotelImgs[$hc % count($allHotelImgs)];
            $others = array_values(array_filter($allHotelImgs, fn($p) => $p !== $img));
            shuffle($others);
            $hotel->update([
                'image'   => $img,
                'gallery' => array_merge([$img], array_slice($others, 0, 3)),
            ]);
            $hc++;
        }
        $updated['hotels'] = $hc;
    });

    return response()->json(['status' => 'done', 'updated' => $updated]);
});

// ===== One-time image setup route =====
// ===== Run migrations from browser =====
// ===== Run fresh migrations + seeding =====
Route::get('/run-migrate', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        return response()->json(['status' => 'done', 'output' => $output]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// ===== Fix hotel images to use working Unsplash URLs =====
Route::get('/fix-hotel-images', function () {
    $images = [
        'https://images.unsplash.com/photo-1534008897995-17a9d4999b1d?auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1522066898748-18e3100e0004?auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1574675681023-4556ca6bf414?auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1588616149176-8f2c3eb76ad4?auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1581452936780-fbcdaebae183?auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1583483955615-5eab38cdae78?auto=format&fit=crop&w=800&q=80',
    ];
    
    $count = 0;
    \App\Models\Hotel::chunk(100, function ($hotels) use ($images, &$count) {
        foreach ($hotels as $hotel) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $hotel */
            /** @var \App\Models\Hotel $hotel */
            // Only fix hotels with broken local paths
            if (str_starts_with($hotel->image ?? '', '/hotels/') || str_starts_with($hotel->image ?? '', '/')) {
                $img = $images[$count % count($images)];
                $hotel->update([
                    'image' => $img,
                    'gallery' => [$img, $images[($count+1) % count($images)], $images[($count+2) % count($images)]],
                ]);
                $count++;
            }
        }
    });
    
    return response()->json(['status' => 'done', 'fixed' => $count . ' hotels updated']);
});

Route::get('/setup-images', function () {
    $brain = 'C:/Users/Technologist/.gemini/antigravity/brain/c2d84a60-43f5-453b-b555-f79cac85e55b';
    $frontendPublic = base_path('../booking-app-main/public');

    $copies = [
        // Era images for TextRevealSection (Egypt Through Time)
        'images/era-pharaonic.png'   => $brain . '/pharaonic_egypt_pyramids_1775066991910.png',
        'images/era-greco-roman.png' => $brain . '/greco_roman_alexandria_1775067015936.png',
        'images/era-coptic.png'      => $brain . '/coptic_egypt_church_1775067032759.png',
        'images/era-islamic.png'     => $brain . '/islamic_egypt_cairo_1775066959857.png',
        'images/era-modern.png'      => $brain . '/modern_egypt_capital_1775066974390.png',
        // Deal cards
        'nile_cruise_deal.png'       => $brain . '/nile_dinner_cruise_elegant_1775055707136.png',
        'pyramids_vip_deal.png'      => $brain . '/pyramids_day_tour_1775063545520.png',
        'aswan_nubian_market.png'    => $brain . '/aswan_nubian_market_1775063685904.png',
        'luxor_souk.png'             => $brain . '/luxor_souk_1775063700541.png',
        // Popular Tours section images
        'images/tour-pyramids.png'       => $brain . '/pyramids_cairo_tour_1775071147110.png',
        'images/tour-nile-cruise.png'    => $brain . '/nile_dinner_cruise_tour_1775071112255.png',
        'images/tour-red-sea.png'        => $brain . '/red_sea_snorkeling_tour_1775071131863.png',
        'images/tour-desert-safari.png'  => $brain . '/desert_safari_atv_tour_1775071172281.png',
        'images/tour-cairo-food.png'     => $brain . '/cairo_food_tour_street_1775071188045.png',
        'images/tour-museum.png'         => $brain . '/egyptian_museum_guided_1775071206904.png',
    ];

    @mkdir($frontendPublic . '/images', 0755, true);

    $results = [];
    foreach ($copies as $dest => $src) {
        if (!file_exists($src)) {
            $results[$dest] = 'âŒ source not found';
            continue;
        }
        $destPath = $frontendPublic . '/' . $dest;
        $ok = @copy($src, $destPath);
        $results[$dest] = $ok ? 'âœ… copied' : 'âŒ failed';
    }

    // ====== AI HOTELS FIX ======
    $newBrain = 'C:/Users/Technologist/.gemini/antigravity/brain/66fb5c08-f331-460b-90d0-ebc614abb105';
    $hotelCopies = [
        'hotels/pyramids.png'         => $newBrain . '/hotel_pyramids_view_1775156544799.png',
        'hotels/nile.png'             => $newBrain . '/hotel_nile_view_1775156561628.png',
        'hotels/redsea.png'           => $newBrain . '/hotel_redsea_view_1775156584896.png',
        'hotels/luxor.png'            => $newBrain . '/hotel_luxor_view_1775156603507.png',
        'hotels/siwa.png'             => $newBrain . '/hotel_siwa_eco_1775166696672.png',
        'hotels/aswan.png'            => $newBrain . '/hotel_nubian_aswan_1775166712736.png',
        'hotels/alex.png'             => $newBrain . '/hotel_alexandria_palace_1775166728597.png',
        'hotels/cairo_boutique.png'   => $newBrain . '/hotel_cairo_boutique_1775166750685.png',
        'hotels/matrouh.png'          => $newBrain . '/hotel_marsa_matrouh_1775166768535.png',
        'hotels/desert.png'           => $newBrain . '/hotel_white_desert_1775166783315.png',
        'hotels/luxor_sunset.png'     => $newBrain . '/hotel_luxor_sunset_1775166904450.png',
        'hotels/sharm_bungalows.png'  => $newBrain . '/hotel_sharm_bungalows_1775166920544.png',
        'hotels/cairo_heritage.png'   => $newBrain . '/hotel_cairo_heritage_1775166934715.png',
        'hotels/aswan_cruise.png'     => $newBrain . '/hotel_aswan_cruise_1775166953308.png',
        'hotels/marsa_lodge.png'      => $newBrain . '/hotel_marsa_alam_lodge_1775166968209.png',
        'hotels/north_coast.png'      => $newBrain . '/hotel_north_coast_1775166984251.png'
    ];

    @mkdir($frontendPublic . '/hotels', 0755, true);
    foreach ($hotelCopies as $dest => $src) {
        if (file_exists($src)) {
            @copy($src, $frontendPublic . '/' . $dest);
            $results[$dest] = 'âœ… AI copied';
        }
    }

    // Update ALL Hotels in DB to use completely diverse AI images!
    \App\Models\Hotel::chunk(100, function ($hotels) {
        $cairoArray     = ['/hotels/pyramids.png', '/hotels/nile.png', '/hotels/cairo_boutique.png', '/hotels/cairo_heritage.png'];
        $coastArray     = ['/hotels/redsea.png', '/hotels/matrouh.png', '/hotels/alex.png', '/hotels/sharm_bungalows.png', '/hotels/marsa_lodge.png', '/hotels/north_coast.png'];
        $saharaArray    = ['/hotels/siwa.png', '/hotels/desert.png'];
        $upperArray     = ['/hotels/luxor.png', '/hotels/aswan.png', '/hotels/luxor_sunset.png', '/hotels/aswan_cruise.png'];
        
        $counters = ['cairo' => 0, 'coast' => 0, 'sahara' => 0, 'upper' => 0];

        foreach ($hotels as $hotel) {
            /** @var \\Illuminate\\Database\\Eloquent\\Model $hotel */
            /** @var \App\Models\Hotel $hotel */
            $loc = strtolower($hotel->location);
            $imagePath = '/hotels/nile.png'; 
            
            if (str_contains($loc, 'cairo') || str_contains($loc, 'giza')) {
                $imagePath = $cairoArray[$counters['cairo']++ % count($cairoArray)];
            } elseif (str_contains($loc, 'sharm') || str_contains($loc, 'hurghada') || str_contains($loc, 'sea') || str_contains($loc, 'matrouh') || str_contains($loc, 'alexandria') || str_contains($loc, 'said')) {
                $imagePath = $coastArray[$counters['coast']++ % count($coastArray)];
            } elseif (str_contains($loc, 'luxor') || str_contains($loc, 'aswan')) {
                $imagePath = $upperArray[$counters['upper']++ % count($upperArray)];
            } elseif (str_contains($loc, 'fayoum') || str_contains($loc, 'siwa')) {
                $imagePath = $saharaArray[$counters['sahara']++ % count($saharaArray)];
            } else {
                $all = array_merge($cairoArray, $coastArray, $saharaArray, $upperArray);
                $imagePath = $all[array_rand($all)];
            }
            
            // Generate diverse gallery from all available images randomly so detail pages look huge
            $galleryPool = array_merge($cairoArray, $coastArray, $saharaArray, $upperArray);
            shuffle($galleryPool);
            
            $hotel->update([
                'image' => $imagePath,
                'gallery' => [
                    $imagePath,
                    $galleryPool[0],
                    $galleryPool[1],
                    $galleryPool[2]
                ]
            ]);
        }
    });

    return response()->json(['status' => 'done', 'results' => $results, 'db_updated' => true]);
});

// ====== AI IMAGES PROXY ROUTE ======
Route::get('/kamet-images/{name}', function ($name) {
    // Read from the copied images in storage
    $path = storage_path('app/kamet-images/' . $name . '.png');
    
    if (file_exists($path)) {
        return response()->file($path);
    }
    
    return response('Not found', 404);
});



Route::prefix('livechat')->group(function () {
    Route::get('/sessions', [\App\Http\Controllers\LiveChatController::class, 'getActiveSessions']);
    Route::get('/sessions/{sessionToken}/messages', [\App\Http\Controllers\LiveChatController::class, 'getSessionMessages']);
    Route::post('/sessions/{sessionToken}/reply', [\App\Http\Controllers\LiveChatController::class, 'replyToSession']);
    Route::post('/sessions/{sessionToken}/close', [\App\Http\Controllers\LiveChatController::class, 'closeSession']);
});

Route::post('/trip-planner/generate', [App\Http\Controllers\TripPlannerController::class, 'generateTrip']);
