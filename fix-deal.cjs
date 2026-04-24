const fs = require('fs');
let file = 'app/Http/Controllers/DealController.php';
let content = fs.readFileSync(file, 'utf8');

const regex = /public function index\(\)[\s\S]*?return response\(\)->json\(\$deals\);\n    \}/;
const replacement = `public function index()
    {
        return response()->json(Deal::orderBy('id', 'desc')->get());
    }`;

content = content.replace(regex, replacement);
fs.writeFileSync(file, content);
