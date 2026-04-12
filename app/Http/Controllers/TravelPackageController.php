<?php

namespace App\Http\Controllers;

use App\Models\TravelPackage;
use Illuminate\Http\Request;

class TravelPackageController extends Controller
{
    public function index()
    {
        return response()->json(TravelPackage::all());
    }

    public function show($id)
    {
        $package = TravelPackage::find($id);
        if (!$package) {
            return response()->json(['message' => 'Travel Package not found'], 404);
        }
        return response()->json($package);
    }
}
