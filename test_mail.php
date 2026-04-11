<?php
// load up Laravel application and test SMTP
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    \Illuminate\Support\Facades\Mail::raw('Test from Kemet', function($msg) {
        $msg->to('dinaabdelbaset08@gmail.com')->subject('Testing Setup');
    });
    echo "SUCCESS";
} catch(\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
