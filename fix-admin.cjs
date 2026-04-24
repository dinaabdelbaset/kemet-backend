const fs = require('fs');
let file = 'e:/اخر تحديث/kemet-backend-main/app/Http/Controllers/AdminController.php';
let content = fs.readFileSync(file, 'utf8');

content = content.replace(/\$data\s*=\s*\$request->validate\(\[[\s\S]*?\]\);/g, 
    `$data = $request->all();
        if (isset($data['name'])) { 
            $data['title'] = $data['name']; 
            unset($data['name']); 
        }
        if (isset($data['price']) && !isset($data['price_starts_from'])) { 
            $data['price_starts_from'] = $data['price']; 
        }`);

fs.writeFileSync(file, content);
console.log('Fixed AdminController validations');
