<?php
$dir = __DIR__.'/database/migrations';
$files = scandir($dir);
foreach ($files as $f) {
    if (strpos($f, 'add_description_to_rooms_table') !== false) {
        $path = $dir . '/' . $f;
        $content = "<?php\nuse Illuminate\Database\Migrations\Migration;\nuse Illuminate\Database\Schema\Blueprint;\nuse Illuminate\Support\Facades\Schema;\n\nreturn new class extends Migration\n{\n    public function up(): void\n    {\n        Schema::table('rooms', function (Blueprint \$table) {\n            \$table->text('description')->nullable()->after('room_type');\n        });\n    }\n\n    public function down(): void\n    {\n        Schema::table('rooms', function (Blueprint \$table) {\n            \$table->dropColumn('description');\n        });\n    }\n};\n";
        file_put_contents($path, $content);
        echo "Updated $path\n";
        break;
    }
}
