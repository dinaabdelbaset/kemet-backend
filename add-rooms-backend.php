<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiFile = __DIR__.'/routes/api.php';
$apiContent = file_get_contents($apiFile);
if (!str_contains($apiContent, "Route::get('/rooms', [AdminController::class, 'rooms']);")) {
    $apiContent = str_replace(
        "Route::get('/hotels', [AdminController::class, 'hotels']);",
        "Route::get('/hotels', [AdminController::class, 'hotels']);\n    Route::get('/rooms', [AdminController::class, 'rooms']);\n    Route::post('/rooms', [AdminController::class, 'storeRoom']);\n    Route::put('/rooms/{id}', [AdminController::class, 'updateRoom']);\n    Route::delete('/rooms/{id}', [AdminController::class, 'deleteRoom']);",
        $apiContent
    );
    file_put_contents($apiFile, $apiContent);
    echo "Added routes to api.php\n";
}

$adminFile = __DIR__.'/app/Http/Controllers/AdminController.php';
$adminContent = file_get_contents($adminFile);
if (!str_contains($adminContent, "public function rooms()")) {
    $methods = <<<PHP
    public function rooms()
    {
        return response()->json(\App\Models\Room::with('hotel')->orderBy('id', 'desc')->get());
    }

    public function storeRoom(\Illuminate\Http\Request \$request)
    {
        \$data = \$request->all();
        \$item = \App\Models\Room::create(\$data);
        return response()->json(\$item, 201);
    }

    public function updateRoom(\Illuminate\Http\Request \$request, \$id)
    {
        \$item = \App\Models\Room::find(\$id);
        if (!\$item) return response()->json(['message' => 'Not found'], 404);
        \$data = \$request->all();
        \$item->update(\$data);
        return response()->json(\$item);
    }

    public function deleteRoom(\$id)
    {
        \$item = \App\Models\Room::find(\$id);
        if (\$item) {
            \$item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
PHP;

    $adminContent = str_replace(
        "public function hotels()",
        $methods . "\n\n    public function hotels()",
        $adminContent
    );
    file_put_contents($adminFile, $adminContent);
    echo "Added methods to AdminController.php\n";
}
