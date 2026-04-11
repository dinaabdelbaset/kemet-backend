<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::all();
        $deals->transform(function($deal) {
            if (str_contains($deal->title, 'Hadramaut')) {
                $deal->image = '/images/home/deal-hadramaut.jpg';
            } elseif (str_contains($deal->title, 'Kempinski')) {
                $deal->image = '/images/home/why-quality.jpg';
            } elseif (str_contains($deal->title, 'Museum')) {
                $deal->image = '/images/museums/gem.jpg';
            } elseif (str_contains($deal->title, 'Sound & Light')) {
                $deal->image = '/images/events/pyramids-sound-light.jpg';
            } elseif (str_contains($deal->title, 'Siwa')) {
                $deal->image = '/images/safaris/siwa-adventure.jpg';
            } elseif (str_contains($deal->title, 'Diving')) {
                $deal->image = '/images/home/cta-redsea.jpg';
            } elseif (str_contains($deal->title, 'Cruise')) {
                $deal->image = '/images/home/cta-bg.jpg';
            }
            return $deal;
        });
        return response()->json($deals);
    }

    public function show($id)
    {
        $deal = Deal::find($id);
        if (!$deal) {
            return response()->json(['message' => 'Deal not found'], 404);
        }
        return response()->json($deal);
    }


}
