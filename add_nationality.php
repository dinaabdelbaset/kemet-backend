<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('users', 'nationality')) {
    Schema::table('users', function (Blueprint $table) {
        $table->string('nationality')->nullable();
    });
    echo "Column nationality created successfully.\n";
} else {
    echo "Column nationality already exists.\n";
}
