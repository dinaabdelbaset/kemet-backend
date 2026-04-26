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
use App\Http\Controllers\ChatbotController;
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

Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(['message' => 'CSRF cookie set']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Unprotected for local demo purposes, but normally wrapped in auth:sanctum & admin middleware)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/stats', [AdminController::class, 'stats']);
    Route::post('/settings', [AdminController::class, 'updateSettings']);
    
    Route::get('/users', [AdminController::class, 'users']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    
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
    Route::post('/approvals/hotels/{id}', [AdminApprovalController::class, 'moderateHotel']);
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

    // Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø·Ù„Ø¨Ø§Øª Ù„Ù„Ù…ØªØ¬Ø±
    Route::get('/orders/my-orders', [OrderController::class, 'userOrders']);
    Route::post('/orders', [OrderController::class, 'store']);
    // Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø´Ø§Øª Ø¨ÙˆØª Ø§Ù„Ù…Ø®ØµØµØ© Ù„Ù„Ø­Ø³Ø§Ø¨Ø§Øª
    Route::post('/chat/auth', [App\Http\Controllers\ChatbotController::class, 'askAuth']);

    // Ù…Ø³Ø§Ø±Ø§Øª Ø¥Ø¶Ø§ÙØ© Ø§Ù„ØªÙ‚ÙŠÙŠÙ…Ø§Øª
    Route::post('/reviews/{item_type}/{item_id}', [ReviewController::class, 'store']);
});

// Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„ÙˆØ¬Ù‡Ø§Øª Ø§Ù„Ø³ÙŠØ§Ø­ÙŠØ© (ÙÙ†Ø§Ø¯Ù‚ØŒ Ù…Ø·Ø§Ø¹Ù…ØŒ Ù…ØªØ§Ø­Ù...)
Route::get('/destinations', [DestinationController::class, 'index']);
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
Route::post('/chat', [App\Http\Controllers\ChatbotController::class, 'ask']);
Route::get('/chat/history', [App\Http\Controllers\ChatbotController::class, 'history']);

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
Route::get('/chatbot-context', [ChatbotController::class, 'getContext']);

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

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø¯Ø¹Ù… ÙˆØ§Ù„ØªÙˆØ§ØµÙ„ (Support & Newsletter) =====
Route::post('/support/contact', [SupportController::class, 'contact']);
Route::post('/newsletter/subscribe', [SupportController::class, 'subscribe']);

// ===== Ù…Ø³Ø§Ø±Ø§Øª Ø§Ù„Ø¯ÙØ¹ (Payments) =====
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
