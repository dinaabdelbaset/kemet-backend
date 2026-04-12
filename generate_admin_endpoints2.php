<?php
$models = ['TravelPackage', 'Review', 'Deal'];

$controllerPath = 'e:\اخر تحديث\kemet-backend-main\app\Http\Controllers\AdminController.php';
$content = file_get_contents($controllerPath);
$content = rtrim($content);
if (substr($content, -1) === '}') {
    $content = substr($content, 0, -1);
}

foreach ($models as $model) {
    if (strpos($content, "public function store{$model}") !== false) continue; // skip if exists

    $modelLower = strtolower($model);
    $modelsLower = $modelLower . 's'; // simple plural

    $code = "
    public function {$modelsLower}()
    {
        if (class_exists('\\App\\Models\\{$model}')) {
             return response()->json(\\App\\Models\\{$model}::orderBy('id', 'desc')->get());
        }
        return response()->json([]);
    }

    public function store{$model}(Request \$request)
    {
        if (!class_exists('\\App\\Models\\{$model}')) return response()->json(['message' => 'Model not found'], 404);
        
        \$data = \$request->all();
        
        \$item = \\App\\Models\\{$model}::create(\$data);
        return response()->json(\$item, 201);
    }

    public function update{$model}(Request \$request, \$id)
    {
        if (!class_exists('\\App\\Models\\{$model}')) return response()->json(['message' => 'Model not found'], 404);
        \$item = \\App\\Models\\{$model}::find(\$id);
        if (!\$item) return response()->json(['message' => 'Not found'], 404);

        \$data = \$request->all();
        \$item->update(\$data);
        return response()->json(\$item);
    }

    public function delete{$model}(\$id)
    {
        if (!class_exists('\\App\\Models\\{$model}')) return response()->json(['message' => 'Model not found'], 404);
        \$item = \\App\\Models\\{$model}::find(\$id);
        if (\$item) {
            \$item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
";
    $content .= $code;
}

$content .= "\n}\n";
file_put_contents($controllerPath, $content);

$apiPath = 'e:\اخر تحديث\kemet-backend-main\routes\api.php';
$apiContent = file_get_contents($apiPath);
$routes = "";
foreach ($models as $model) {
    $modelLower = strtolower($model);
    $modelsLower = $modelLower . 's';
    
    if (strpos($apiContent, "Route::get('/{$modelsLower}'") !== false) continue;

    $routes .= "
    Route::get('/{$modelsLower}', [AdminController::class, '{$modelsLower}']);
    Route::post('/{$modelsLower}', [AdminController::class, 'store{$model}']);
    Route::put('/{$modelsLower}/{id}', [AdminController::class, 'update{$model}']);
    Route::delete('/{$modelsLower}/{id}', [AdminController::class, 'delete{$model}']);
";
}

$apiContent = str_replace("});\n\nRoute::get('/home'", $routes . "});\n\nRoute::get('/home'", $apiContent);
file_put_contents($apiPath, $apiContent);

// Add missing Models if they dont exist just to prevent errors
$dealModel = '<?php namespace App\Models; use Illuminate\Database\Eloquent\Factories\HasFactory; use Illuminate\Database\Eloquent\Model; class Deal extends Model { use HasFactory; protected $guarded = []; }';
if (!file_exists("e:\\اخر تحديث\\kemet-backend-main\\app\\Models\\Deal.php")) {
    file_put_contents("e:\\اخر تحديث\\kemet-backend-main\\app\\Models\\Deal.php", $dealModel);
}

echo "Backend generated successfully.";
