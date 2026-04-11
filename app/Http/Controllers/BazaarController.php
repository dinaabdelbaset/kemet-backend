<?php

namespace App\Http\Controllers;

use App\Models\Bazaar;
use Illuminate\Http\Request;

class BazaarController extends Controller
{
    public function index()
    {
        if (Bazaar::count() === 0) {
            $this->seedBazaars();
        }
        return response()->json(Bazaar::all());
    }

    private function seedBazaars()
    {
        $data = [
            [
              'title' => 'Khan el-Khalili',
              'location' => 'Cairo',
              'image' => '/images/bazaars/khan-el-khalili.jpg',
              'description' => 'A famous historic bazaar and souq in the center of Cairo. Master artisans craft beautiful jewelry, copper, and lanterns right before your eyes.',
              'specialty' => ['Spices', 'Handicrafts', 'Jewelry', 'Antiques'],
            ],
            [
              'title' => 'Aswan Spice Market',
              'location' => 'Aswan',
              'image' => '/images/bazaars/aswan-spice.jpg',
              'description' => 'A sensory explosion of colors and aromas. Best place to buy authentic Nubian spices, hibiscus tea, and natural perfumes.',
              'specialty' => ['Spices', 'Herbs', 'Perfumes', 'Tea'],
            ],
            [
              'title' => 'Luxor Tourist Souq',
              'location' => 'Luxor',
              'image' => '/images/bazaars/luxor-souq.jpg',
              'description' => 'Wander through lanes dedicated to alabaster statues, papyrus art, and traditional clothing near the glorious Luxor Temple.',
              'specialty' => ['Alabaster', 'Papyrus', 'Cotton', 'Statues'],
            ],
            [
              'title' => 'Sharm Old Market',
              'location' => 'Sharm El-Sheikh',
              'image' => '/images/bazaars/sharm-old-market.jpg',
              'description' => 'Also known as Sharm El Maya. Famous for its beautiful Sahaba Mosque, traditional herbs, essential oils, and local cafes.',
              'specialty' => ['Oils', 'Herbs', 'Souvenirs', 'Leather'],
            ],
            [
              'title' => 'Mansheya Market',
              'location' => 'Alexandria',
              'image' => '/images/bazaars/mansheya-market.jpg',
              'description' => 'A vibrant local market near the sea. Famous for fresh Mediterranean produce, street food, and authentic Egyptian daily life.',
              'specialty' => ['Street Food', 'Produce', 'Clothing', 'Coffee'],
            ],
            [
              'title' => 'El Dahar Souq',
              'location' => 'Hurghada',
              'image' => '/images/bazaars/el-dahar.jpg',
              'description' => 'The old town market of Hurghada. A great place to haggle for souvenirs, try local fruits, and experience the non-touristy side of the Red Sea.',
              'specialty' => ['Souvenirs', 'Fruits', 'Spices', 'Crafts'],
            ]
        ];

        foreach ($data as $item) {
            Bazaar::create($item);
        }
    }

    public function show($id)
    {
        $bazaar = Bazaar::find($id);
        if (!$bazaar) {
            return response()->json(['message' => 'Bazaar not found'], 404);
        }
        return response()->json($bazaar);
    }
}
