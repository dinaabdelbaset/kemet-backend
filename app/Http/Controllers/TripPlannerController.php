<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroqService;
use App\Models\Hotel;
use App\Models\Tour;
use App\Models\Transportation;
use Illuminate\Support\Facades\Log;

class TripPlannerController extends Controller
{
    private GroqService $aiService;

    public function __construct(GroqService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function generateTrip(Request $request)
    {
        $request->validate([
            'destination' => 'required|string',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'days' => 'required|integer|min:1',
            'budget' => 'required|numeric|min:0',
            'currency' => 'required|string|in:USD,EGP,EUR,GBP',
            'vibe' => 'required|string',
        ]);

        $destination = $request->input('destination');
        $budget = $request->input('budget');
        $currency = $request->input('currency', 'USD');
        $days = $request->input('days');
        
        // Fetch real data to pass to the AI context
        $hotels = Hotel::where('location', 'like', "%{$destination}%")->limit(3)->get(['id', 'title as name', 'price_starts_from as price', 'rating', 'image']);
        if ($hotels->isEmpty()) {
            $hotels = Hotel::limit(2)->get(['id', 'title as name', 'price_starts_from as price', 'rating', 'image']);
        }
        
        $tours = Tour::where('location', 'like', "%{$destination}%")->limit(4)->get(['id', 'title', 'price', 'image']);
        $transportation = Transportation::where('route', 'like', "%{$destination}%")->limit(2)->get(['id', 'company as name', 'price', 'route']);

        $systemContext = "You are an expert AI Travel Planner for Kemet, an Egyptian tourism platform. Your job is to output a raw JSON object containing a perfectly planned trip. DO NOT output any markdown blocks like ```json, just output the raw JSON directly.";
        
        $dbContext = "Available Database Data for $destination:\n";
        $dbContext .= "Hotels:\n" . json_encode($hotels) . "\n";
        $dbContext .= "Tours:\n" . json_encode($tours) . "\n";
        $dbContext .= "Transport:\n" . json_encode($transportation) . "\n";

        $prompt = "Create a $days-day trip to $destination for {$request->adults} adults and {$request->children} children. The vibe is '{$request->vibe}'. Total budget: $budget $currency.\n\n";
        $prompt .= $dbContext . "\n\n";
        $prompt .= "You MUST return ONLY a valid JSON object matching exactly this structure:
{
  \"title\": \"Catchy Trip Title in Arabic (e.g. رحلة القاهرة الساحرة)\",
  \"hotel\": { \"id\": 1, \"name\": \"Hotel Name\", \"price\": 100, \"rating\": 4.5, \"image\": \"image_url\" },
  \"itinerary\": [
    {
      \"day\": 1,
      \"activities\": [
        { \"name\": \"Activity Name (Arabic)\", \"category\": \"🗺️ جولة OR 🍽️ مطعم OR 🏛️ متحف OR 🛍️ بازار\", \"time\": \"9:00 AM - 1:00 PM\", \"type\": \"type of activity\", \"price\": 50, \"image\": \"image_url\" }
      ]
    }
  ],
  \"transport\": { \"name\": \"Transport Name\", \"route\": \"Route Info\", \"price\": 20, \"link\": \"/transportation/1\" },
  \"totalCost\": 500,
  \"days\": $days,
  \"destination\": \"$destination\"
}

CRITICAL RULES:
1. You MUST pick the 'hotel', 'activities/tours', and 'transport' strictly from the Available Database Data if possible. Use their exact names, prices, and image URLs.
2. If there are not enough tours/restaurants in the database, invent realistic ones for Egypt, but use this placeholder for their image: 'https://images.unsplash.com/photo-1544148103-0773bf10d330?w=400'.
3. 'totalCost' should be the sum of all activities, hotel nights, and transport. Ensure it doesn't exceed the $budget too much.
4. ONLY return a raw, valid JSON object.";

        $response = $this->aiService->ask($prompt, $systemContext);

        // Strip markdown if the AI stubbornly adds it
        $jsonStr = trim($response);
        if (str_starts_with($jsonStr, '```json')) {
            $jsonStr = substr($jsonStr, 7);
            if (str_ends_with($jsonStr, '```')) {
                $jsonStr = substr($jsonStr, 0, -3);
            }
        } elseif (str_starts_with($jsonStr, '```')) {
            $jsonStr = substr($jsonStr, 3);
            if (str_ends_with($jsonStr, '```')) {
                $jsonStr = substr($jsonStr, 0, -3);
            }
        }
        
        $jsonStr = trim($jsonStr);
        $tripData = json_decode($jsonStr, true);

        if (!$tripData) {
            Log::error("TripPlanner AI JSON Parse Error", ['raw_response' => $response]);
            return response()->json(['error' => 'The AI failed to generate a valid itinerary. Please try again.', 'raw' => $response], 500);
        }

        return response()->json($tripData);
    }
}
