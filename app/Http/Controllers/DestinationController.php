<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $destinations = \App\Models\Destination::all()->map(function ($dest) {

            // Hardcode geographically perfect images onto Both properties so the Frontend sees them directly
            // Force Local images only to avoid all 404s and Unsplash issues forever
            if ($dest->title === 'Cairo') {
                $dest->src = '/images/tour-desert-safari.png'; // User requested this for Cairo
                $dest->image = null;
            }
            if ($dest->title === 'Alexandria') {
                $dest->src = '/images/era-greco-roman.png';
                $dest->image = null;
            }
            if ($dest->title === 'Luxor') {
                $dest->src = '/images/luxor-souk.png';
                $dest->image = null;
            }
            if ($dest->title === 'Aswan') {
                $dest->src = '/images/aswan-nubian-market.png';
                $dest->image = null;
            }
            if ($dest->title === 'Hurghada') {
                $dest->src = '/images/tour-red-sea.png';
                $dest->image = null;
            }
            if ($dest->title === 'Sharm El.S') {
                $dest->src = '/images/home/dest-redsea.jpg';
                $dest->image = null;
            }
            if ($dest->title === 'Marsa Alam') {
                $dest->src = '/images/tour-red-sea.png'; // Red sea image for Marsa Alam
                $dest->image = null;
            }
            if ($dest->title === 'Dahab') {
                $dest->src = '/images/saint-catherine.png';
                $dest->image = null;
            }

            if ($dest->image && !str_starts_with($dest->image, 'http') && !str_starts_with($dest->image, '/')) {
                $dest->image = url($dest->image);
            } elseif (!$dest->image) {
                $dest->image = null;
            }
            return $dest;
        });
        return response()->json($destinations);
    }

    public function show($id)
    {
        $dest = \App\Models\Destination::find($id);
        if ($dest) {
            if ($dest->image && !str_starts_with($dest->image, 'http')) {
                $dest->image = url($dest->image);
            } elseif (!$dest->image) {
                $dest->image = null;
            }
            return response()->json($dest);
        }
        return response()->json(['error' => 'Not found'], 404);
    }
}
