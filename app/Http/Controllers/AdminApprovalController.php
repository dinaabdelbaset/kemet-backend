<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class AdminApprovalController extends Controller
{
    /**
     * Get all pending items (hotels for now).
     */
    public function getPendingItems()
    {
        $pendingHotels = Hotel::where('status', 'pending')->get();
        
        return response()->json([
            'hotels' => $pendingHotels
        ]);
    }

    /**
     * Approve or reject a specific hotel.
     */
    public function moderateHotel(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject'
        ]);

        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        if ($request->action === 'approve') {
            $hotel->status = 'approved';
            $hotel->save();
            return response()->json(['message' => 'Hotel approved successfully']);
        }

        if ($request->action === 'reject') {
            $hotel->status = 'rejected';
            $hotel->save();
            return response()->json(['message' => 'Hotel rejected successfully']);
        }
    }
}
