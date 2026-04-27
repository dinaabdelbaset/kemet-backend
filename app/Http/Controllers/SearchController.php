<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Tour;
use App\Models\Restaurant;
use App\Models\Activity;
use App\Models\Destination;
use App\Models\Event;
use App\Models\Museum;
use App\Models\Safari;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim($request->input('q', ''));

        if (empty($query)) {
            return response()->json([
                'hotels' => [],
                'tours' => [],
                'restaurants' => [],
                'events' => [],
                'museums' => [],
                'safaris' => [],
                'destinations' => [],
            ]);
        }

        // Basic Arabic Keyword Mapping to English equivalent or broad matching
        $searchQuery = $query;
        $isRestaurantKeyword = in_array(mb_strtolower($query), ['مطعم', 'مطاعم', 'restaurant', 'restaurants', 'food']);
        $isHotelKeyword = in_array(mb_strtolower($query), ['فندق', 'فنادق', 'hotel', 'hotels']);
        $isSafariKeyword = in_array(mb_strtolower($query), ['سفاري', 'صحراء', 'safari', 'desert']);
        $isMuseumKeyword = in_array(mb_strtolower($query), ['متحف', 'متاحف', 'museum', 'museums']);
        $isTourKeyword = in_array(mb_strtolower($query), ['جولة', 'جولات', 'رحلة', 'رحلات', 'tour', 'tours']);

        // Bilingual translation mapping for robust search
        $translations = [
            'القاهرة' => 'Cairo', 'cairo' => 'القاهرة',
            'الاسكندرية' => 'Alexandria', 'الإسكندرية' => 'Alexandria', 'alexandria' => 'الإسكندرية',
            'شرم' => 'Sharm', 'شرم الشيخ' => 'Sharm', 'sharm' => 'شرم',
            'الغردقة' => 'Hurghada', 'hurghada' => 'الغردقة',
            'الاقصر' => 'Luxor', 'الأقصر' => 'Luxor', 'luxor' => 'الأقصر',
            'اسوان' => 'Aswan', 'أسوان' => 'Aswan', 'aswan' => 'أسوان',
            'الفيوم' => 'Fayoum', 'fayoum' => 'الفيوم',
            'الجيزة' => 'Giza', 'giza' => 'الجيزة',
            'الجونة' => 'Gouna', 'gouna' => 'الجونة',
            'دهب' => 'Dahab', 'dahab' => 'دهب'
        ];

        $translatedQuery = $searchQuery;
        foreach ($translations as $key => $val) {
            if (mb_stripos($searchQuery, $key) !== false) {
                $translatedQuery = $val;
                break;
            }
        }

        $hotels = Hotel::when(!$isHotelKeyword, function($q) use ($searchQuery, $translatedQuery) {
                return $q->where('title', 'like', "%{$searchQuery}%")
                         ->orWhere('location', 'like', "%{$searchQuery}%")
                         ->orWhere('description', 'like', "%{$searchQuery}%")
                         ->orWhere('title', 'like', "%{$translatedQuery}%")
                         ->orWhere('location', 'like', "%{$translatedQuery}%")
                         ->orWhere('description', 'like', "%{$translatedQuery}%");
            })
            ->limit(8)
            ->get();

        $tours = Tour::when(!$isTourKeyword, function($q) use ($searchQuery, $translatedQuery) {
                return $q->where('title', 'like', "%{$searchQuery}%")
                         ->orWhere('location', 'like', "%{$searchQuery}%")
                         ->orWhere('description', 'like', "%{$searchQuery}%")
                         ->orWhere('title', 'like', "%{$translatedQuery}%")
                         ->orWhere('location', 'like', "%{$translatedQuery}%")
                         ->orWhere('description', 'like', "%{$translatedQuery}%");
            })
            ->limit(8)
            ->get();

        $restaurants = [];
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('restaurants')) {
                $restaurants = Restaurant::when(!$isRestaurantKeyword, function($q) use ($searchQuery, $translatedQuery) {
                        return $q->where('name', 'like', "%{$searchQuery}%")
                                 ->orWhere('location', 'like', "%{$searchQuery}%")
                                 ->orWhere('cuisine', 'like', "%{$searchQuery}%")
                                 ->orWhere('name', 'like', "%{$translatedQuery}%")
                                 ->orWhere('location', 'like', "%{$translatedQuery}%")
                                 ->orWhere('cuisine', 'like', "%{$translatedQuery}%");
                    })
                    ->limit(8)
                    ->get();
            }
        } catch (\Exception $e) {}

        $events = [];
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('events')) {
                $events = Event::where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('location', 'like', "%{$searchQuery}%")
                    ->orWhere('title', 'like', "%{$translatedQuery}%")
                    ->orWhere('location', 'like', "%{$translatedQuery}%")
                    ->limit(8)
                    ->get();
            }
        } catch (\Exception $e) {}

        $museums = [];
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('museums')) {
                $museums = Museum::when(!$isMuseumKeyword, function($q) use ($searchQuery, $translatedQuery) {
                        return $q->where('name', 'like', "%{$searchQuery}%")
                                 ->orWhere('location', 'like', "%{$searchQuery}%")
                                 ->orWhere('name', 'like', "%{$translatedQuery}%")
                                 ->orWhere('location', 'like', "%{$translatedQuery}%");
                    })
                    ->limit(8)
                    ->get();
            }
        } catch (\Exception $e) {}

        $safaris = [];
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('safaris')) {
                $safaris = Safari::when(!$isSafariKeyword, function($q) use ($searchQuery, $translatedQuery) {
                        return $q->where('title', 'like', "%{$searchQuery}%")
                                 ->orWhere('location', 'like', "%{$searchQuery}%")
                                 ->orWhere('title', 'like', "%{$translatedQuery}%")
                                 ->orWhere('location', 'like', "%{$translatedQuery}%");
                    })
                    ->limit(8)
                    ->get();
            }
        } catch (\Exception $e) {}

        $destinations = [];
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('destinations')) {
                $destinations = Destination::where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('title', 'like', "%{$translatedQuery}%")
                    ->limit(8)
                    ->get();
            }
        } catch (\Exception $e) {}

        return response()->json([
            'hotels' => $hotels,
            'tours' => $tours,
            'restaurants' => $restaurants,
            'events' => $events,
            'museums' => $museums,
            'safaris' => $safaris,
            'destinations' => $destinations,
        ]);
    }
}
