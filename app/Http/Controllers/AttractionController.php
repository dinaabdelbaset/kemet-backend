<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use Illuminate\Http\Request;

class AttractionController extends Controller
{
    public function index()
    {
        if (Attraction::count() === 0) {
            $this->seedAttractions();
        }
        return response()->json(Attraction::all());
    }

    public function show($slug)
    {
        if (Attraction::count() === 0) {
            $this->seedAttractions();
        }

        $attraction = Attraction::where('slug', $slug)->first();
        if (!$attraction) {
            return response()->json(['message' => 'Attraction not found'], 404);
        }
        return response()->json($attraction);
    }

    private function seedAttractions()
    {
        $contentController = new ContentController();
        // Since attractionsData is private, we can't call it directly. I'll just use reflection or a simpler way: copy it here or make it public.
        // Actually, it's easier to just use the json response from getAttractions!
        $response = clone $contentController->getAttractions();
        $data = json_decode($response->getContent(), true);
        
        foreach ($data as $slug => $item) {
            Attraction::create($item);
        }
    }
}
