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
});

Route::get('/home', [HomeController::class, 'index']);

// مسارات الفنادق
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

    // مسارات الطلبات للمتجر
    Route::get('/orders/my-orders', [OrderController::class, 'userOrders']);
    Route::post('/orders', [OrderController::class, 'store']);
    // مسارات استرجاع محادثات الشات بوت للعميل
    Route::get('/chat/history', [App\Http\Controllers\ChatbotController::class, 'history']);

    // مسارات الشات بوت المخصصة للحسابات
    Route::post('/chat/auth', [App\Http\Controllers\ChatbotController::class, 'askAuth']);

    // مسارات إضافة التقييمات
    Route::post('/reviews/{item_type}/{item_id}', [ReviewController::class, 'store']);
});

// مسارات الوجهات السياحية (فنادق، مطاعم، متاحف...)
Route::get('/destinations', [DestinationController::class, 'index']);
Route::get('/destinations/search', [DestinationController::class, 'search']);

// ==========================================
// Support & Newsletter Routes
// ==========================================

Route::post('/support/contact', [SupportController::class, 'contact']);
Route::post('/newsletter/subscribe', [SupportController::class, 'subscribe']);

Route::get('/destinations/{id}', [DestinationController::class, 'show']);
Route::post('/destinations', [DestinationController::class, 'store']); // يستحسن لاحقاً حمايتها بحساب المدير

// مسارات الرحلات والباقات
Route::get('/tours', [TourController::class, 'index']);
Route::get('/tours/{id}', [TourController::class, 'show']);
Route::post('/tours', [TourController::class, 'store']);

// مسارات الأنشطة (Popular Things To Do)
Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/activities/{id}', [ActivityController::class, 'show']);

// مسارات متجر الهدايا والمنتجات (E-Commerce)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// مسارات استرجاع التقييمات للجمهور
Route::get('/reviews', [ReviewController::class, 'allReviews']);
Route::get('/reviews/{item_type}/{item_id}', [ReviewController::class, 'index']);

// مسار الشات بوت الحقيقي المدعوم بالذكاء الاصطناعي (Gemini / Groq LLM)
Route::post('/chat', [App\Http\Controllers\ChatbotController::class, 'ask']);

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

// ===== بيانات الشات بوت الحية من الداتا بيز =====
Route::get('/chatbot-context', function () {
    $data = [];

    // Hotels with prices (EGP)
    if (\Schema::hasTable('hotels')) {
        $data['hotels'] = \App\Models\Hotel::select('title', 'location', 'price_starts_from', 'rating')
            ->orderBy('rating', 'desc')->limit(25)->get()
            ->map(fn($h) => "{$h->title} - {$h->location} - من {$h->price_starts_from} ج.م/ليلة - تقييم {$h->rating}⭐")
            ->implode("\n");
    }

    // Tours with prices (EGP)
    if (\Schema::hasTable('tours')) {
        $data['tours'] = \App\Models\Tour::select('title', 'location', 'price', 'duration')
            ->orderBy('price')->get()
            ->map(fn($t) => "{$t->title} - {$t->location} - {$t->price} ج.م/شخص" . ($t->duration ? " - {$t->duration}" : ""))
            ->implode("\n");
    }

    // Restaurants with prices (EGP)
    if (\Schema::hasTable('restaurants')) {
        $data['restaurants'] = \App\Models\Restaurant::select('name', 'cuisine', 'location', 'price_range_min', 'price_range_max', 'rating')
            ->orderBy('rating', 'desc')->limit(20)->get()
            ->map(fn($r) => "{$r->name} - {$r->cuisine} - {$r->location} - {$r->price_range_min}-{$r->price_range_max} ج.م/شخص - {$r->rating}⭐")
            ->implode("\n");
    }

    // Safaris with prices (EGP)
    if (\Schema::hasTable('safaris')) {
        $data['safaris'] = \App\Models\Safari::select('title', 'location', 'price', 'duration', 'rating')
            ->get()
            ->map(fn($s) => "{$s->title} - {$s->location} - {$s->price} ج.م/شخص - {$s->duration} - {$s->rating}⭐")
            ->implode("\n");
    }

    // Museums with ticket prices (EGP)
    if (\Schema::hasTable('museums')) {
        $data['museums'] = \App\Models\Museum::select('name', 'location', 'ticket_price', 'rating')
            ->get()
            ->map(fn($m) => "{$m->name} - {$m->location} - تذكرة {$m->ticket_price} ج.م - {$m->rating}⭐")
            ->implode("\n");
    }

    // Products (souvenirs) with prices (EGP)
    if (\Schema::hasTable('products')) {
        $data['products'] = \App\Models\Product::select('name', 'category', 'price')
            ->orderBy('category')->get()
            ->map(fn($p) => "{$p->name} ({$p->category}) - {$p->price} ج.م")
            ->implode("\n");
    }

    // Deals (EGP)
    if (\Schema::hasTable('deals')) {
        $data['deals'] = \App\Models\Deal::select('title', 'category', 'price', 'locations')
            ->limit(10)->get()
            ->map(fn($d) => "{$d->title} ({$d->category}) - {$d->price} ج.م" . ($d->locations ? " - {$d->locations}" : ""))
            ->implode("\n");
    }

    // Destinations
    if (\Schema::hasTable('destinations')) {
        $data['destinations'] = \App\Models\Destination::select('title', 'tours')
            ->get()
            ->map(fn($d) => "{$d->title} ({$d->tours} رحلة)")
            ->implode(", ");
    }

    // Bazaars & Shopping
    if (\Schema::hasTable('bazaars')) {
        $data['bazaars'] = \App\Models\Bazaar::select('title', 'location', 'specialty')
            ->get()
            ->map(function($b) {
                $spec = $b->specialty;
                if (is_array($spec)) $spec = implode(', ', $spec);
                return "{$b->title} - {$b->location}" . ($spec ? " - تخصص: {$spec}" : "");
            })
            ->implode("\n");
    }

    // Events & Festivals (EGP)
    if (\Schema::hasTable('events')) {
        $data['events'] = \App\Models\Event::select('title', 'location', 'venue', 'date', 'price', 'category', 'rating')
            ->get()
            ->map(fn($e) => "{$e->title} ({$e->category}) - {$e->location}" . ($e->venue ? " - {$e->venue}" : "") . " - {$e->price} ج.م" . ($e->date ? " - {$e->date}" : "") . " - {$e->rating}⭐")
            ->implode("\n");
    }

    // Transportation (EGP)
    if (\Schema::hasTable('transportations')) {
        $data['transportation'] = \App\Models\Transportation::select('type', 'route', 'company', 'class', 'price', 'duration', 'rating')
            ->get()
            ->map(fn($t) => "{$t->type}: {$t->route} - {$t->company} ({$t->class}) - {$t->price} ج.م - {$t->duration} - {$t->rating}⭐")
            ->implode("\n");
    }

    // ===== أسعار الصرف الحية =====
    try {
        $response = \Illuminate\Support\Facades\Http::timeout(5)
            ->get('https://api.exchangerate-api.com/v4/latest/EGP');
        if ($response->successful()) {
            $rates = $response->json('rates');
            $data['exchange_rates'] = "1 دولار أمريكي (USD) = " . round(1 / $rates['USD'], 2) . " ج.م\n"
                . "1 يورو (EUR) = " . round(1 / $rates['EUR'], 2) . " ج.م\n"
                . "1 جنيه إسترليني (GBP) = " . round(1 / $rates['GBP'], 2) . " ج.م\n"
                . "1 ريال سعودي (SAR) = " . round(1 / $rates['SAR'], 2) . " ج.م\n"
                . "1 درهم إماراتي (AED) = " . round(1 / $rates['AED'], 2) . " ج.م\n"
                . "1 دينار كويتي (KWD) = " . round(1 / $rates['KWD'], 2) . " ج.م";
        }
    } catch (\Exception $e) {
        // Fallback - سعر تقريبي
        $data['exchange_rates'] = "1 دولار أمريكي (USD) ≈ 51 ج.م\n"
            . "1 يورو (EUR) ≈ 57 ج.م\n"
            . "1 جنيه إسترليني (GBP) ≈ 65 ج.م\n"
            . "1 ريال سعودي (SAR) ≈ 13.6 ج.م\n"
            . "1 درهم إماراتي (AED) ≈ 13.9 ج.م";
    }

    return response()->json($data);
});

// ===== مسارات المدونة والمقالات (Blogs / Travel Guides) =====
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);

// ===== مسارات العروض والصفقات (Deals) =====
Route::get('/deals', [DealController::class, 'index']);
Route::get('/deals/{id}', [DealController::class, 'show']);

// ===== مسارات الباقات السياحية (Travel Packages) =====
Route::get('/travelpackages', [TravelPackageController::class, 'index']);
Route::get('/travelpackages/{id}', [TravelPackageController::class, 'show']);

// ===== مسارات البحث (Global Search) =====
Route::get('/search', [SearchController::class, 'search']);

// ===== مسارات المطاعم (Restaurants) =====
Route::get('/restaurants', [RestaurantController::class, 'index']);
Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);

// ===== مسارات الأحداث والفعاليات (Events) =====
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);

// ===== مسارات المتاحف والمعالم (Museums & Landmarks) =====
Route::get('/museums', [MuseumController::class, 'index']);
Route::get('/museums/{id}', [MuseumController::class, 'show']);

// ===== مسارات الأسواق والتسوق (Bazaars & Shopping) =====
Route::get('/bazaars', [BazaarController::class, 'index']);
Route::get('/bazaars/{id}', [BazaarController::class, 'show']);

// ===== مسارات السفاري والصحراء (Safaris) =====
Route::get('/safaris', [SafariController::class, 'index']);
Route::get('/safaris/{id}', [SafariController::class, 'show']);

// ===== مسارات المواصلات (Transportation) =====
Route::get('/transportation', [TransportationController::class, 'index']);
Route::get('/transportation/{id}', [TransportationController::class, 'show']);

// ===== مسارات المحتوى الثابت (CMS Content & FAQs) =====
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

// ===== مسارات الدعم والتواصل (Support & Newsletter) =====
Route::post('/support/contact', [SupportController::class, 'contact']);
Route::post('/newsletter/subscribe', [SupportController::class, 'subscribe']);

// ===== مسارات الدفع (Payments) =====
Route::post('/payment/process', [PaymentController::class, 'process']);
Route::get('/payment/status/{transactionId}', [PaymentController::class, 'status']);

// ===== مسارات محمية (Wishlist & Notifications) - تحتاج تسجيل دخول =====
Route::middleware('auth:sanctum')->group(function () {
    // المفضلة (Wishlist)
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);

    // الإشعارات (Notifications)
    Route::get('/user/notifications', [NotificationController::class, 'index']);
    Route::put('/user/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/user/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

    // السلة (Cart)
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{productId}', [CartController::class, 'destroy']);
    Route::delete('/cart', [CartController::class, 'clear']);
    // Checkout OTP routes
    Route::post('/checkout/send-otp', [PaymentController::class, 'sendCheckoutOTP']);
    Route::post('/checkout/verify-otp', [PaymentController::class, 'verifyCheckoutOTP']);
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
            $results[$dest] = '❌ source not found';
            continue;
        }
        $destPath = $frontendPublic . '/' . $dest;
        $ok = @copy($src, $destPath);
        $results[$dest] = $ok ? '✅ copied' : '❌ failed';
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
            $results[$dest] = '✅ AI copied';
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
