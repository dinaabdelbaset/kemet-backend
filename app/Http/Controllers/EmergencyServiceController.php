<?php

namespace App\Http\Controllers;

use App\Models\EmergencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmergencyServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EmergencyService::query();

        // Admin flag (internal route check or general parameter)
        $isAdmin = $request->has('admin_view') && $request->input('admin_view') === 'true';

        if (!$isAdmin) {
            $query->where('status', 'approved');
        }

        // Filter by type
        if ($request->has('type') && $request->input('type') !== 'All') {
            $query->where('type', $request->input('type'));
        }

        // Filter by city
        if ($request->has('city') && $request->input('city') !== 'All') {
            $city = $request->input('city');
            $query->where(function($q) use ($city) {
                $q->where('city', $city)
                  ->orWhere('city', 'All'); // Include nationwide services
            });
        }

        $services = $query->orderBy('type', 'asc')->orderBy('name', 'asc')->get();

        return response()->json($services);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|in:hospital,pharmacy,embassy,hotline',
            'phone' => 'required|string|max:50',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'details' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $service = EmergencyService::create($request->all());

        return response()->json([
            'message' => 'Emergency service created successfully',
            'service' => $service
        ], 21);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $service = EmergencyService::find($id);

        if (!$service) {
            return response()->json(['message' => 'Emergency service not found'], 404);
        }

        return response()->json($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $service = EmergencyService::find($id);

        if (!$service) {
            return response()->json(['message' => 'Emergency service not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:hospital,pharmacy,embassy,hotline',
            'phone' => 'sometimes|required|string|max:50',
            'city' => 'sometimes|required|string|max:100',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'details' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $service->update($request->all());

        return response()->json([
            'message' => 'Emergency service updated successfully',
            'service' => $service
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = EmergencyService::find($id);

        if (!$service) {
            return response()->json(['message' => 'Emergency service not found'], 404);
        }

        $service->delete();

        return response()->json(['message' => 'Emergency service deleted successfully']);
    }
}
