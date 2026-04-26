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
            'action' => 'required|in:approve,reject',
            'reason' => 'nullable|string'
        ]);

        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        if ($request->action === 'approve') {
            if ($hotel->action_type === 'delete') {
                $hotel->delete();
                return response()->json(['message' => 'Hotel deletion approved']);
            } else {
                $hotel->status = 'approved';
                $hotel->action_type = 'create'; // reset
                $hotel->rejection_reason = null;
                $hotel->save();
                return response()->json(['message' => 'Hotel approved successfully']);
            }
        }

        if ($request->action === 'reject') {
            $hotel->status = 'rejected';
            $hotel->rejection_reason = $request->reason;
            $hotel->save();
            return response()->json(['message' => 'Hotel rejected successfully']);
        }
    }
}
