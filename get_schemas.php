<?php
$schemas = [
    'events' => array_keys(\App\Models\Event::first()->toArray()),
    'museums' => array_keys(\App\Models\Museum::first()->toArray()),
    'tours' => array_keys(\App\Models\Tour::first()->toArray()),
    'safaris' => array_keys(\App\Models\Safari::first()->toArray()),
    'travel_packages' => array_keys(\App\Models\TravelPackage::first()->toArray()),
];
echo json_encode($schemas, JSON_PRETTY_PRINT);
