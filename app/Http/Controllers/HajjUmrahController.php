<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HajjUmrahPackage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class HajjUmrahController extends Controller
{
    /**
     * Display a listing of Hajj & Umrah packages.
     */
    public function getPackages()
    {
        $packages = HajjUmrahPackage::with(['hotelMakkah', 'hotelMadinah', 'flight', 'transportation'])
            ->orderBy('price', 'asc')
            ->get();
        return response()->json($packages);
    }

    /**
     * Programmatic reseed helper for Hajj & Umrah.
     */
    public function reseed()
    {
        try {
            // Run migrations to ensure table exists
            Artisan::call('migrate');
            
            // Truncate packages table
            HajjUmrahPackage::truncate();

            // Run seeder directly
            $seeder = new \Database\Seeders\HajjUmrahSeeder();
            $seeder->run();

            return response()->json([
                'status' => 'Hajj & Umrah packages re-seeded successfully ✅',
                'packages_count' => HajjUmrahPackage::count(),
            ]);
        } catch (\Exception $e) {
            Log::error("Reseed Hajj & Umrah failed: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    //  Admin CRUD Actions for Hajj & Umrah Packages
    // =========================================================================

    public function storePackage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'hotel_makkah_en' => 'nullable|string|max:255',
            'hotel_makkah_ar' => 'nullable|string|max:255',
            'hotel_madinah_en' => 'nullable|string|max:255',
            'hotel_madinah_ar' => 'nullable|string|max:255',
            'hotel_makkah_id' => 'nullable|integer|exists:hotels,id',
            'hotel_madinah_id' => 'nullable|integer|exists:hotels,id',
            'flight_id' => 'nullable|integer|exists:flights,id',
            'transportation_id' => 'nullable|integer|exists:transportations,id',
            'duration_days' => 'required|integer|min:1',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'image' => 'nullable|string|max:500',
            'features_en' => 'nullable|array',
            'features_ar' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $package = HajjUmrahPackage::create($request->all());
        
        // Eager load relationships for return payload
        $package->load(['hotelMakkah', 'hotelMadinah', 'flight', 'transportation']);

        return response()->json(['message' => 'Package created successfully', 'package' => $package], 201);
    }

    public function updatePackage(Request $request, $id)
    {
        $package = HajjUmrahPackage::find($id);
        if (!$package) {
            return response()->json(['message' => 'Package not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name_en' => 'sometimes|required|string|max:255',
            'name_ar' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'hotel_makkah_en' => 'nullable|string|max:255',
            'hotel_makkah_ar' => 'nullable|string|max:255',
            'hotel_madinah_en' => 'nullable|string|max:255',
            'hotel_madinah_ar' => 'nullable|string|max:255',
            'hotel_makkah_id' => 'nullable|integer|exists:hotels,id',
            'hotel_madinah_id' => 'nullable|integer|exists:hotels,id',
            'flight_id' => 'nullable|integer|exists:flights,id',
            'transportation_id' => 'nullable|integer|exists:transportations,id',
            'duration_days' => 'sometimes|required|integer|min:1',
            'description_en' => 'sometimes|required|string',
            'description_ar' => 'sometimes|required|string',
            'image' => 'nullable|string|max:500',
            'features_en' => 'nullable|array',
            'features_ar' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $package->update($request->all());
        
        // Eager load relationships for return payload
        $package->load(['hotelMakkah', 'hotelMadinah', 'flight', 'transportation']);

        return response()->json(['message' => 'Package updated successfully', 'package' => $package]);
    }

    public function destroyPackage($id)
    {
        $package = HajjUmrahPackage::find($id);
        if (!$package) {
            return response()->json(['message' => 'Package not found'], 404);
        }

        $package->delete();
        return response()->json(['message' => 'Package deleted successfully']);
    }
}
