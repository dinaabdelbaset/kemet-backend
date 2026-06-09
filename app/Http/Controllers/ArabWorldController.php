<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArabCountry;
use App\Models\ArabLandmark;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ArabWorldController extends Controller
{
    /**
     * Display a listing of Arab countries.
     */
    public function getCountries()
    {
        $countries = ArabCountry::withCount('landmarks')->orderBy('name_en', 'asc')->get();
        return response()->json($countries);
    }

    /**
     * Display a listing of Arab landmarks with optional filters.
     */
    public function getLandmarks(Request $request)
    {
        $query = ArabLandmark::with('country');

        if ($request->has('country_id') && $request->input('country_id') !== 'All') {
            $query->where('country_id', $request->input('country_id'));
        }

        if ($request->has('category') && $request->input('category') !== 'All') {
            $query->where('category', $request->input('category'));
        }

        $landmarks = $query->orderBy('rating', 'desc')->orderBy('name_en', 'asc')->get();
        return response()->json($landmarks);
    }

    /**
     * Programmatic reseed helper.
     */
    public function reseed()
    {
        try {
            Artisan::call('migrate');
            
            // Truncate tables securely
            ArabLandmark::truncate();
            
            // Turn off foreign key checks to truncate parent table
            \Schema::disableForeignKeyConstraints();
            ArabCountry::truncate();
            \Schema::enableForeignKeyConstraints();

            $seeder = new \Database\Seeders\ArabWorldSeeder();
            $seeder->run();

            return response()->json([
                'status' => 'Arab World Tourism tables migrated and seeded successfully ✅',
                'countries_count' => ArabCountry::count(),
                'landmarks_count' => ArabLandmark::count(),
            ]);
        } catch (\Exception $e) {
            Log::error("Reseed Arab World failed: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    //  Admin CRUD Actions for Countries
    // =========================================================================

    public function storeCountry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'code' => 'required|string|max:5|unique:arab_countries,code',
            'flag' => 'required|string|max:50',
            'image' => 'required|string|max:500',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $country = ArabCountry::create($request->all());
        return response()->json(['message' => 'Country created successfully', 'country' => $country], 201);
    }

    public function updateCountry(Request $request, $id)
    {
        $country = ArabCountry::find($id);
        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name_en' => 'sometimes|required|string|max:255',
            'name_ar' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:5|unique:arab_countries,code,' . $id,
            'flag' => 'sometimes|required|string|max:50',
            'image' => 'sometimes|required|string|max:500',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $country->update($request->all());
        return response()->json(['message' => 'Country updated successfully', 'country' => $country]);
    }

    public function destroyCountry($id)
    {
        $country = ArabCountry::find($id);
        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        $country->delete();
        return response()->json(['message' => 'Country deleted successfully']);
    }

    // =========================================================================
    //  Admin CRUD Actions for Landmarks
    // =========================================================================

    public function storeLandmark(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:arab_countries,id',
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'location_en' => 'required|string|max:255',
            'location_ar' => 'required|string|max:255',
            'category' => 'required|in:historical,modern,nature',
            'image' => 'required|string|max:500',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'rating' => 'nullable|numeric|between:0,5',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $landmark = ArabLandmark::create($request->all());
        return response()->json(['message' => 'Landmark created successfully', 'landmark' => $landmark], 201);
    }

    public function updateLandmark(Request $request, $id)
    {
        $landmark = ArabLandmark::find($id);
        if (!$landmark) {
            return response()->json(['message' => 'Landmark not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'country_id' => 'sometimes|required|exists:arab_countries,id',
            'name_en' => 'sometimes|required|string|max:255',
            'name_ar' => 'sometimes|required|string|max:255',
            'location_en' => 'sometimes|required|string|max:255',
            'location_ar' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|in:historical,modern,nature',
            'image' => 'sometimes|required|string|max:500',
            'description_en' => 'sometimes|required|string',
            'description_ar' => 'sometimes|required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'rating' => 'nullable|numeric|between:0,5',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $landmark->update($request->all());
        return response()->json(['message' => 'Landmark updated successfully', 'landmark' => $landmark]);
    }

    public function destroyLandmark($id)
    {
        $landmark = ArabLandmark::find($id);
        if (!$landmark) {
            return response()->json(['message' => 'Landmark not found'], 404);
        }

        $landmark->delete();
        return response()->json(['message' => 'Landmark deleted successfully']);
    }
}
