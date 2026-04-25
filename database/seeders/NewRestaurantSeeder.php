<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewRestaurantSeeder extends Seeder
{
    public function run()
    {
        DB::table('restaurants')->truncate();

        $restaurants = [
            // Cairo & Giza
            ['name' => 'Baha (بحة الناصرية)', 'image' => '/images/restaurants/generic_traditional.png', 'location' => 'Cairo', 'cuisine' => 'Masmat & Mombar', 'rating' => 4.8, 'reviews_count' => 1200, 'opening_hours' => '12:00 PM - 03:00 AM', 'description' => 'المسمط الأصلي - فواكه اللحوم، ممبار، وفشة ولية. ترند السياحة الشعبية.'],
            ['name' => 'Sobhy Kaber (صبحي كابر)', 'image' => '/images/restaurants/cairo/el_prince.png', 'location' => 'Cairo', 'cuisine' => 'Tagines & Liver', 'rating' => 4.9, 'reviews_count' => 3500, 'opening_hours' => '01:00 PM - 04:00 AM', 'description' => 'طواجن وكبدة - الملوخية اللي بتنزل بالشهقة والكبدة اللي باللية.'],
            ['name' => 'Qasr El Kababgy (قصر الكبابجي)', 'image' => '/images/restaurants/generic_grill.png', 'location' => 'Cairo', 'cuisine' => 'Oriental Grills', 'rating' => 4.9, 'reviews_count' => 2800, 'opening_hours' => '01:00 PM - 02:00 AM', 'description' => 'مشويات على الطريقة المصرية - كباب وكفتة وريش في جو فخم جداً.'],
            ['name' => 'Abou Tarek (كشري أبو طارق)', 'image' => '/images/restaurants/cairo/abou_tarek.png', 'location' => 'Cairo', 'cuisine' => 'Koshary', 'rating' => 4.8, 'reviews_count' => 5000, 'opening_hours' => '10:00 AM - 02:00 AM', 'description' => 'متخصص في الكشري فقط، مفيش سياح بييجوا القاهرة من غير ما يروحوه.'],
            ['name' => 'Hadramout Antar (حضرموت عنتر)', 'image' => '/images/restaurants/generic_grill.png', 'location' => 'Cairo', 'cuisine' => 'Mandi & Madhbi', 'rating' => 4.7, 'reviews_count' => 2100, 'opening_hours' => '12:00 PM - 03:00 AM', 'description' => 'مندي ومظبي - صواني اللحم والرز البسمتي والذبيحة اللي بتتقدم كاملة.'],
            ['name' => 'Khufus (خوفو الأهرامات)', 'image' => '/images/restaurants/generic_traditional.png', 'location' => 'Giza', 'cuisine' => 'Fine Dining', 'rating' => 4.9, 'reviews_count' => 800, 'opening_hours' => '08:00 AM - 11:00 PM', 'description' => 'تجربة Fine Dining - أكل مصري بأسلوب الفنادق العالمية وفيو التاريخ الأهرامات.'],

            // Alexandria
            ['name' => 'Halaket El Samak (حلقة السمك)', 'image' => '/images/restaurants/generic_seafood.png', 'location' => 'Alexandria', 'cuisine' => 'Fresh Seafood', 'rating' => 4.8, 'reviews_count' => 1500, 'opening_hours' => '10:00 AM - 12:00 AM', 'description' => 'اختيار السمك من الشيلة وطبخه فوراً على ذوقك.'],
            ['name' => 'Kebdet El Falah (كبدة الفلاح)', 'image' => '/images/restaurants/generic_traditional.png', 'location' => 'Alexandria', 'cuisine' => 'Alexandrian Liver', 'rating' => 4.9, 'reviews_count' => 4200, 'opening_hours' => '12:00 PM - 04:00 AM', 'description' => 'متخصص في ساندوتشات الكبدة الإسكندراني الصغيرة، مفيش سمك ولا مشويات.'],
            ['name' => 'Alban Swesra (ألبان سويسرا)', 'image' => '/images/restaurants/generic_traditional.png', 'location' => 'Alexandria', 'cuisine' => 'Cheese Inventions', 'rating' => 4.7, 'reviews_count' => 1800, 'opening_hours' => '09:00 AM - 02:00 AM', 'description' => 'اختراعات الجبن - سجق وبسطرمة غرقانة في شلال جبن شيدر.'],
            ['name' => 'Abdel Wahab Village (قرية عبد الوهاب)', 'image' => '/images/restaurants/generic_grill.png', 'location' => 'Alexandria', 'cuisine' => 'Grills & Hadramout', 'rating' => 4.6, 'reviews_count' => 1100, 'opening_hours' => '12:00 PM - 02:00 AM', 'description' => 'متخصص في اللحوم المندي والمشوية على الفحم.'],
            ['name' => 'Kadoura (قدورة)', 'image' => '/images/restaurants/kadoura.png', 'location' => 'Alexandria', 'cuisine' => 'Masmat & Popular', 'rating' => 4.7, 'reviews_count' => 2200, 'opening_hours' => '11:00 AM - 03:00 AM', 'description' => 'مشهور جداً بالأطباق الشعبية الإسكندرانية والشوربة الحرشة والمسمط.'],
            ['name' => 'Delices (ديليس)', 'image' => '/images/restaurants/generic_traditional.png', 'location' => 'Alexandria', 'cuisine' => 'Greek Bakery & Desserts', 'rating' => 4.9, 'reviews_count' => 950, 'opening_hours' => '07:00 AM - 12:00 AM', 'description' => 'حلويات ومخبوزات يونانية - عشان يحلوا بعد الأكل في كافيه تاريخي.'],

            // Luxor & Aswan
            ['name' => 'Solaih (صُليح النوبي)', 'image' => '/images/restaurants/aswan/solaih.png', 'location' => 'Aswan', 'cuisine' => 'Authentic Nubian', 'rating' => 4.8, 'reviews_count' => 700, 'opening_hours' => '12:00 PM - 11:00 PM', 'description' => 'نوبي أصيل - الجاكود والويكة والرز بالشعيرية في قلب النيل.'],
            ['name' => 'Sofra (سفرة الأقصر)', 'image' => '/images/restaurants/luxor/sofra.png', 'location' => 'Luxor', 'cuisine' => 'Egyptian Home Cooking', 'rating' => 4.9, 'reviews_count' => 1200, 'opening_hours' => '11:00 AM - 10:00 PM', 'description' => 'أكل بيتي مصري - حمام محشي وملوخية في بيت أثري.'],
            ['name' => 'Hadramout El Saeed (حضرموت الصعيد)', 'image' => '/images/restaurants/generic_grill.png', 'location' => 'Luxor', 'cuisine' => 'Mandi & Meats', 'rating' => 4.6, 'reviews_count' => 500, 'opening_hours' => '12:00 PM - 01:00 AM', 'description' => 'متخصص في صواني اللحم الضاني والرز اللي بيحبها السياح بعد يوم طويل.'],
            ['name' => 'Al-Sahaby Lane (السحابي)', 'image' => '/images/restaurants/luxor/sahaby.png', 'location' => 'Luxor', 'cuisine' => 'Steaks & Camel Meat', 'rating' => 4.7, 'reviews_count' => 850, 'opening_hours' => '10:00 AM - 12:00 AM', 'description' => 'متخصص في ستيك الجمال وأطباق انترناشونال للي عاوز يغير.'],
            ['name' => 'El Dokka (مطعم الدكة)', 'image' => '/images/restaurants/aswan/el_dokka.png', 'location' => 'Aswan', 'cuisine' => 'Saeedi Masmat', 'rating' => 4.5, 'reviews_count' => 600, 'opening_hours' => '12:00 PM - 11:00 PM', 'description' => 'متخصص في حلويات المذبح والكوارع بطريقة أهل الجنوب.'],
            ['name' => 'The Terrace Old Cataract (ذا تيراس)', 'image' => '/images/restaurants/generic_traditional.png', 'location' => 'Aswan', 'cuisine' => 'High Tea & Breakfast', 'rating' => 5.0, 'reviews_count' => 1500, 'opening_hours' => '07:00 AM - 10:00 PM', 'description' => 'تجربة الفطور الملكي والشاي وقت الغروب في فندق أولد كتراكت الأسطوري.'],

            // Sharm El-Sheikh & Hurghada
            ['name' => 'Farsha (فرشة)', 'image' => '/images/restaurants/generic_fayoum.png', 'location' => 'Sharm El Sheikh', 'cuisine' => 'Bedouin Vibe & Pizza', 'rating' => 4.9, 'reviews_count' => 6000, 'opening_hours' => '04:00 PM - 02:00 AM', 'description' => 'التركيز هنا على المشروبات والأكل الخفيف والبيتزا في ديكور بدوي أسطوري.'],
            ['name' => 'Starfish (ستار فيش)', 'image' => '/images/restaurants/hurghada/starfish.png', 'location' => 'Hurghada', 'cuisine' => 'Seafood', 'rating' => 4.8, 'reviews_count' => 2500, 'opening_hours' => '11:00 AM - 12:00 AM', 'description' => 'شوربة الفواكه بالكريمة وأسماك البحر الأحمر.'],
            ['name' => 'Waha El Zaitoun (واحة الزيتون)', 'image' => '/images/restaurants/generic_fayoum.png', 'location' => 'Hurghada', 'cuisine' => 'Bedouin Mandi', 'rating' => 4.6, 'reviews_count' => 800, 'opening_hours' => '12:00 PM - 12:00 AM', 'description' => 'أكل حضرموت وبدوي، اللحم المدفون تحت الأرض والمنسف.'],
            ['name' => 'El Masrien (المصريين)', 'image' => '/images/restaurants/masrien.png', 'location' => 'Sharm El Sheikh', 'cuisine' => 'Egyptian Grills', 'rating' => 4.7, 'reviews_count' => 1400, 'opening_hours' => '01:00 PM - 03:00 AM', 'description' => 'كباب وكفتة وحمام محشي بخلطة مصرية أصيلة.'],
            ['name' => 'Little Buddha (ليتل بودا)', 'image' => '/images/restaurants/generic_traditional.png', 'location' => 'Sharm El Sheikh', 'cuisine' => 'Sushi & Asian', 'rating' => 4.8, 'reviews_count' => 3100, 'opening_hours' => '06:00 PM - 04:00 AM', 'description' => 'تجربة عالمية للسياح اللي بيحبوا التغيير بالليل، سوشي وآسيوي.'],
            ['name' => 'Gad (مطعم جاد)', 'image' => '/images/restaurants/hurghada/gad.png', 'location' => 'Hurghada', 'cuisine' => 'Foul & Falafel', 'rating' => 4.4, 'reviews_count' => 4500, 'opening_hours' => '06:00 AM - 02:00 AM', 'description' => 'متخصص في الفطور المصري الشعبي والفطير اللي السياح بيعشقوه.'],

            // Fayoum
            ['name' => 'Ibis Tunis Village (إيبيس قرية تونس)', 'image' => '/images/restaurants/generic_fayoum.png', 'location' => 'Fayoum', 'cuisine' => 'Falahi Breakfast', 'rating' => 4.9, 'reviews_count' => 400, 'opening_hours' => '08:00 AM - 06:00 PM', 'description' => 'فطار فلاحي - فطير مشلتت، مش، عسل، وجبن قريش من الفلاحين مباشرة.'],
            ['name' => 'Tunis Lake (تونس ليك)', 'image' => '/images/restaurants/generic_fayoum.png', 'location' => 'Fayoum', 'cuisine' => 'Open Air Grills', 'rating' => 4.6, 'reviews_count' => 350, 'opening_hours' => '12:00 PM - 08:00 PM', 'description' => 'مشويات - كفتة وطرب في الهواء الطلق وسط الأشجار.'],
            ['name' => 'Qasr Rashwan (قصر رشوان)', 'image' => '/images/restaurants/generic_traditional.png', 'location' => 'Fayoum', 'cuisine' => 'Ducks & Pigeons', 'rating' => 4.8, 'reviews_count' => 600, 'opening_hours' => '01:00 PM - 10:00 PM', 'description' => 'ملك البط المحشي بالمرتة والأرز والحمام، أكلة فيومية تقيلة.'],
            ['name' => 'Zad Restaurant (مطعم زاد)', 'image' => '/images/restaurants/generic_traditional.png', 'location' => 'Fayoum', 'cuisine' => 'Oven Tagines', 'rating' => 4.7, 'reviews_count' => 280, 'opening_hours' => '12:00 PM - 11:00 PM', 'description' => 'طواجن فرني - طواجن لحم بالبصل وخضار في الفرن البلدي.'],
            ['name' => 'El Gabaly (الجبلي)', 'image' => '/images/restaurants/generic_seafood.png', 'location' => 'Fayoum', 'cuisine' => 'Lake Qarun Fish', 'rating' => 4.5, 'reviews_count' => 500, 'opening_hours' => '11:00 AM - 09:00 PM', 'description' => 'سمك الموسى والجمبري اللي بتشتهر بيه بحيرة قارون.'],
            ['name' => 'Hadramout Fayoum (حضرموت الفيوم)', 'image' => '/images/restaurants/generic_fayoum.png', 'location' => 'Fayoum', 'cuisine' => 'Mandi', 'rating' => 4.4, 'reviews_count' => 320, 'opening_hours' => '12:00 PM - 11:00 PM', 'description' => 'صواني لحم تيس مندي مع أرز مبهر، تجربة حضرموت وسط الريف.'],

            // Port Said & Matrouh
            ['name' => 'El Borg (مطعم البرج)', 'image' => '/images/restaurants/generic_seafood.png', 'location' => 'Port Said', 'cuisine' => 'Port Said Seafood', 'rating' => 4.8, 'reviews_count' => 1900, 'opening_hours' => '11:00 AM - 12:00 AM', 'description' => 'السيبيا والجمبري المفتوح والخلطات البورسعيدية.'],
            ['name' => 'Abou Sultan (أبو سلطان)', 'image' => '/images/restaurants/generic_fayoum.png', 'location' => 'Marsa Matrouh', 'cuisine' => 'Bedouin Mansaf', 'rating' => 4.7, 'reviews_count' => 850, 'opening_hours' => '12:00 PM - 02:00 AM', 'description' => 'أكل واحاتي وبدوي - المنسف واللحم المكمور، مفيش سمك هنا.'],
            ['name' => 'Casten (كاستن)', 'image' => '/images/restaurants/generic_traditional.png', 'location' => 'Port Said', 'cuisine' => 'Masmat', 'rating' => 4.6, 'reviews_count' => 1100, 'opening_hours' => '12:00 PM - 03:00 AM', 'description' => 'كوارع، طحال، وممبار بورسعيدي حرش.'],
            ['name' => 'Daawa (دعوة)', 'image' => '/images/restaurants/generic_seafood.png', 'location' => 'Port Said', 'cuisine' => 'Sayadia & Home Cooking', 'rating' => 4.5, 'reviews_count' => 700, 'opening_hours' => '12:00 PM - 11:00 PM', 'description' => 'متخصص في الرز الصيادية البني والسمك المطبوخ.'],
            ['name' => 'Koshary El Tahrir (كشري التحرير)', 'image' => '/images/restaurants/generic_koshary.png', 'location' => 'Port Said', 'cuisine' => 'Koshary', 'rating' => 4.8, 'reviews_count' => 3000, 'opening_hours' => '10:00 AM - 02:00 AM', 'description' => 'عشان يرضي جميع الأذواق السياحية بكشري التحرير الأصيل.'],
            ['name' => 'Corallo (كورالو)', 'image' => '/images/restaurants/generic_traditional.png', 'location' => 'Marsa Matrouh', 'cuisine' => 'Italian Pasta & Pizza', 'rating' => 4.9, 'reviews_count' => 500, 'opening_hours' => '02:00 PM - 01:00 AM', 'description' => 'أكل إيطالي راقي جداً بفيو المالديف المصري.']
        ];

        foreach ($restaurants as $r) {
            DB::table('restaurants')->insert([
                'name' => $r['name'],
                'description' => $r['description'],
                'image' => $r['image'],
                'cuisine' => $r['cuisine'],
                'price_range_min' => 50.00,
                'price_range_max' => 300.00,
                'location' => $r['location'],
                'rating' => $r['rating'],
                'reviews_count' => $r['reviews_count'],
                'opening_hours' => $r['opening_hours'],
                'address' => 'Local Address',
                'features' => json_encode(['Wifi', 'Parking', 'Family Friendly']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
