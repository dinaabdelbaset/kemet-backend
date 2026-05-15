<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;

class VisionController extends Controller
{
    private GeminiService $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // Base64 encoded string
        ]);

        $base64Image = $request->input('image');

        // Extract mime type and clean base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png', 'webp' ])) {
                throw new \Exception('invalid image type');
            }
            $mimeType = "image/" . ($type == 'jpg' ? 'jpeg' : $type);
        } else {
            return response()->json(['error' => 'Invalid image format. Expected base64 data URI.'], 400);
        }

        $prompt = "You are an Egyptian tourism expert. Analyze this image and identify the exact location or monument in Egypt. Provide your answer in a strictly formatted JSON structure: {\"destination\": \"City Name\", \"monument\": \"Monument Name\", \"vibe\": \"One of: History & Culture 🏛️, Relaxation & Spa 💆‍♂️, Adventure & Safari 🏜️, Entertainment & Nightlife 🪩\"}. Return ONLY the JSON object, no markdown formatting.";

        $response = $this->geminiService->analyzeImage($base64Image, $mimeType, $prompt);

        // Try to parse the JSON
        $jsonStart = strpos($response, '{');
        $jsonEnd = strrpos($response, '}');
        
        if ($jsonStart !== false && $jsonEnd !== false) {
            $jsonStr = substr($response, $jsonStart, $jsonEnd - $jsonStart + 1);
            $data = json_decode($jsonStr, true);
            if ($data) {
                return response()->json($data);
            }
        }

        return response()->json([
            'error' => 'Could not determine location from image.',
            'raw' => $response
        ], 400);
    }
}
