<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Tour;
use App\Models\Restaurant;
use App\Models\Museum;
use App\Models\Bazaar;
use App\Models\Event;
use App\Models\Safari;
use App\Models\Transportation;

class AdminApprovalController extends Controller
{
    private $models = [
        'hotel' => Hotel::class,
        'tour' => Tour::class,
        'restaurant' => Restaurant::class,
        'museum' => Museum::class,
        'bazaar' => Bazaar::class,
        'event' => Event::class,
        'safari' => Safari::class,
        'transportation' => Transportation::class,
    ];

    public function getPendingItems(Request $request)
    {
        // Mock role based access (in real app, use $request->user()->role)
        // role can be passed as header or query for demo, or hardcoded to super_admin
        $role = $request->header('X-Admin-Role', 'super_admin');
        
        $pendingItems = [];

        foreach ($this->models as $type => $modelClass) {
            // Role-based access control
            if ($role !== 'super_admin' && $role !== "{$type}_admin") {
                continue;
            }

            $items = $modelClass::where('status', 'pending')->get();
            foreach ($items as $item) {
                $itemArray = $item->toArray();
                $itemArray['type'] = $type;
                $itemArray['title'] = $itemArray['title'] ?? $itemArray['name'] ?? $itemArray['company'] ?? 'Unknown Title';
                $itemArray['location'] = $itemArray['location'] ?? $itemArray['city'] ?? $itemArray['route'] ?? 'N/A';
                $itemArray['price'] = $itemArray['price_starts_from'] ?? $itemArray['price'] ?? 0;
                $pendingItems[] = $itemArray;
            }
        }

        return response()->json([
            'items' => $pendingItems
        ]);
    }

    public function moderateItem(Request $request, $type, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'reason' => 'nullable|string'
        ]);

        if (!array_key_exists($type, $this->models)) {
            return response()->json(['message' => 'Invalid type'], 400);
        }

        $modelClass = $this->models[$type];
        $item = $modelClass::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        if ($request->action === 'approve') {
            if ($item->action_type === 'delete') {
                $item->delete();
                return response()->json(['message' => 'Deletion approved']);
            } else {
                $item->status = 'approved';
                $item->action_type = 'create'; // reset
                $item->rejection_reason = null;
                $item->save();
                return response()->json(['message' => 'Item approved successfully']);
            }
        }

        if ($request->action === 'reject') {
            $item->status = 'rejected';
            $item->rejection_reason = $request->reason;
            $item->save();
            return response()->json(['message' => 'Item rejected successfully']);
        }
    }
}
