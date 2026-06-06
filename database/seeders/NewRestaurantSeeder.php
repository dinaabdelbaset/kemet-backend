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
            // 1. Cairo
            ['name' => 'Baha (بحة الناصرية)', 'image' => '/images/restaurants/cairo/baha.png', 'location' => 'Cairo', 'cuisine' => 'Masmat & Mombar', 'rating' => 4.8, 'reviews_count' => 1200, 'opening_hours' => '12:00 PM - 03:00 AM', 'description' => 'المسمط الأصلي - فواكه اللحوم، ممبار، وفشة ولية. ترند السياحة الشعبية.'],
            ['name' => 'Sobhy Kaber (صبحي كابر)', 'image' => '/images/restaurants/cairo/sobhy_kaber.png', 'location' => 'Cairo', 'cuisine' => 'Tagines & Liver', 'rating' => 4.9, 'reviews_count' => 3500, 'opening_hours' => '01:00 PM - 04:00 AM', 'description' => 'طواجن وكبدة - الملوخية اللي بتنزل بالشهقة والكبدة اللي باللية.'],
            ['name' => 'Qasr El Kababgy (قصر الكبابجي)', 'image' => '/images/restaurants/cairo/qasr_el_kababgy.png', 'location' => 'Cairo', 'cuisine' => 'Oriental Grills', 'rating' => 4.9, 'reviews_count' => 2800, 'opening_hours' => '01:00 PM - 02:00 AM', 'description' => 'مشويات على الطريقة المصرية - كباب وكفتة وريش في جو فخم جداً.'],

            // 2. Giza
            ['name' => 'Khufus (خوفو الأهرامات)', 'image' => '/images/restaurants/r3.png', 'location' => 'Giza', 'cuisine' => 'Fine Dining', 'rating' => 4.9, 'reviews_count' => 800, 'opening_hours' => '08:00 AM - 11:00 PM', 'description' => 'أكل مصري بأسلوب الفنادق العالمية وفيو تاريخي مباشر على الأهرامات.'],
            ['name' => 'Andrea El Mariouteya (أندريا المريوطية)', 'image' => '/images/restaurants/cairo/qasr_el_kababgy.png', 'location' => 'Giza', 'cuisine' => 'Grilled Chicken', 'rating' => 4.7, 'reviews_count' => 1900, 'opening_hours' => '12:00 PM - 12:00 AM', 'description' => 'أشهر فرخ مشوي بلدي في مصر، على تلة تطل على ريف الجيزة مع طواجن ساخنة.'],
            ['name' => '139 Restaurant (مطعم 139 ماريوت)', 'image' => '/images/restaurants/r3.png', 'location' => 'Giza', 'cuisine' => 'International & Egyptian', 'rating' => 4.8, 'reviews_count' => 1500, 'opening_hours' => '24 Hours', 'description' => 'مطعم فندق مينا هاوس بفيو الأهرامات الأسطوري وخدمة خمس نجوم فاخرة.'],

            // 3. Alexandria
            ['name' => 'Kebdet El Falah (كبدة الفلاح)', 'image' => '/images/restaurants/alexandria/kebdet_falah.png', 'location' => 'Alexandria', 'cuisine' => 'Alexandrian Liver', 'rating' => 4.9, 'reviews_count' => 4200, 'opening_hours' => '12:00 PM - 04:00 AM', 'description' => 'متخصص في ساندوتشات الكبدة الإسكندراني الصغيرة، مفيش سمك ولا مشويات.'],
            ['name' => 'Alban Swesra (ألبان سويسرا)', 'image' => '/images/restaurants/albanswesra_alex_v2_1777139522954.png', 'location' => 'Alexandria', 'cuisine' => 'Cheese Inventions', 'rating' => 4.7, 'reviews_count' => 1800, 'opening_hours' => '09:00 AM - 02:00 AM', 'description' => 'اختراعات الجبن - سجق وبسطرمة غرقانة في شلال جبن شيدر.'],
            ['name' => 'Halaket El Samak (حلقة السمك)', 'image' => '/images/restaurants/r4.png', 'location' => 'Alexandria', 'cuisine' => 'Fresh Seafood', 'rating' => 4.8, 'reviews_count' => 1500, 'opening_hours' => '10:00 AM - 12:00 AM', 'description' => 'اختيار السمك من الشيلة وطبخه فوراً على ذوقك مع إطلالة على بحر الإسكندرية.'],

            // 4. Luxor
            ['name' => 'Sofra (سفرة الأقصر)', 'image' => '/images/restaurants/luxor/sofra.png', 'location' => 'Luxor', 'cuisine' => 'Egyptian Home Cooking', 'rating' => 4.9, 'reviews_count' => 1200, 'opening_hours' => '11:00 AM - 10:00 PM', 'description' => 'أكل بيتي مصري حمام محشي وملوخية وبامية باللحمة في بيت أثري دافئ.'],
            ['name' => 'Al-Sahaby Lane (السحابي)', 'image' => '/images/restaurants/luxor/sahaby.png', 'location' => 'Luxor', 'cuisine' => 'Camel Meat & Steaks', 'rating' => 4.7, 'reviews_count' => 850, 'opening_hours' => '10:00 AM - 12:00 AM', 'description' => 'مطعم تاريخي في سوق الأقصر يقدم برجر ستيك الجمال وأطباق شرقية مميزة بفيو السوق.'],
            ['name' => 'El Kababgy Luxor (كبابجي الأقصر)', 'image' => '/images/restaurants/luxor/sahaby.png', 'location' => 'Luxor', 'cuisine' => 'Oriental Grills', 'rating' => 4.6, 'reviews_count' => 600, 'opening_hours' => '12:00 PM - 11:00 PM', 'description' => 'أشهى المشويات الشرقية على الفحم من ريش وكفتة وحواوشي بجوار معبد الأقصر.'],

            // 5. Aswan
            ['name' => 'Solaih (صُليح النوبي)', 'image' => '/images/restaurants/aswan/solaih.png', 'location' => 'Aswan', 'cuisine' => 'Authentic Nubian', 'rating' => 4.8, 'reviews_count' => 700, 'opening_hours' => '12:00 PM - 11:00 PM', 'description' => 'نوبي أصيل - الجاكود والويكة والرز بالشعيرية والطيور في قلب النيل بجزيرة هيسا.'],
            ['name' => 'El Dokka (مطعم الدكة)', 'image' => '/images/restaurants/aswan/el_dokka.png', 'location' => 'Aswan', 'cuisine' => 'Saeedi Masmat', 'rating' => 4.5, 'reviews_count' => 600, 'opening_hours' => '12:00 PM - 11:00 PM', 'description' => 'متخصص في الأكل الصعيدي وحلويات المذبح والكوارع بطريقة أهل الجنوب بجزيرة سهيل.'],
            ['name' => 'Aswan Moon (أسوان مون)', 'image' => '/images/restaurants/aswan/aswan_moon.png', 'location' => 'Aswan', 'cuisine' => 'Egyptian & Grills', 'rating' => 4.8, 'reviews_count' => 1300, 'opening_hours' => '08:00 AM - 11:00 PM', 'description' => 'أشهر مطعم عائم على النيل في أسوان، قعدة خرافية وأكل مصري أصيل ومشويات فحم.'],

            // 6. Sharm El-Sheikh
            ['name' => 'Farsha (فرشة الشاطئ)', 'image' => '/images/restaurants/sharm/farsha.png', 'location' => 'Sharm El-Sheikh', 'cuisine' => 'Bedouin Vibe & Pizza', 'rating' => 4.9, 'reviews_count' => 6000, 'opening_hours' => '04:00 PM - 02:00 AM', 'description' => 'التركيز هنا على المشروبات والأكل الخفيف والبيتزا في ديكور بدوي أسطوري على المنحدر.'],
            ['name' => 'El Masrien (المصريين)', 'image' => '/images/restaurants/masrien.png', 'location' => 'Sharm El-Sheikh', 'cuisine' => 'Egyptian Grills', 'rating' => 4.7, 'reviews_count' => 1400, 'opening_hours' => '01:00 PM - 03:00 AM', 'description' => 'كباب وكفتة وحمام محشي بخلطة مصرية شعبية أصيلة في قلب السوق القديم.'],
            ['name' => 'Fares Seafood (فارس للمأكولات البحرية)', 'image' => '/images/restaurants/sharm/little_buddha.png', 'location' => 'Sharm El-Sheikh', 'cuisine' => 'Fresh Seafood', 'rating' => 4.8, 'reviews_count' => 3200, 'opening_hours' => '11:00 AM - 01:00 AM', 'description' => 'الشوربة الحارقة بالكريمة والسمك السنجاري، أشهر مطعم سمك في شرم الشيخ.'],

            // 7. Hurghada
            ['name' => 'Starfish (ستار فيش)', 'image' => '/images/restaurants/hurghada/starfish.png', 'location' => 'Hurghada', 'cuisine' => 'Seafood', 'rating' => 4.8, 'reviews_count' => 2500, 'opening_hours' => '11:00 AM - 12:00 AM', 'description' => 'شوربة الفواكه بالكريمة وأسماك البحر الأحمر الطازجة سنجاري ومشوي على الفحم.'],
            ['name' => 'Waha El Zaitoun (واحة الزيتون)', 'image' => '/images/restaurants/hurghada/waha_zaitoun.png', 'location' => 'Hurghada', 'cuisine' => 'Bedouin Mandi', 'rating' => 4.6, 'reviews_count' => 800, 'opening_hours' => '12:00 PM - 12:00 AM', 'description' => 'أكل واحاتي وبدوي، اللحم المدفون تحت الأرض والمنسف والأرز المبهر.'],
            ['name' => 'El Halaka (مطعم الحلقة)', 'image' => '/images/restaurants/hurghada/gad.png', 'location' => 'Hurghada', 'cuisine' => 'Fresh Red Sea Fish', 'rating' => 4.7, 'reviews_count' => 1900, 'opening_hours' => '10:00 AM - 11:30 PM', 'description' => 'مطعم سمك بلدي مميز يقع مباشرة أمام حلقة السمك بالغردقة ويقدم صيد اليوم.'],

            // 8. Marsa Alam
            ['name' => 'Wadi El Gemal Restaurant (مطعم وادي الجمال)', 'image' => '/images/restaurants/hurghada/starfish.png', 'location' => 'Marsa Alam', 'cuisine' => 'Bedouin Grill & Seafood', 'rating' => 4.7, 'reviews_count' => 300, 'opening_hours' => '12:00 PM - 10:00 PM', 'description' => 'أكل بدوي أصيل ولحوم مشوية مع إطلالة على محمية وادي الجمال وشواطئ مرسى علم.'],
            ['name' => 'Port Ghalib Fish Market (سوق السمك بورت غالب)', 'image' => '/images/restaurants/hurghada/waha_zaitoun.png', 'location' => 'Marsa Alam', 'cuisine' => 'Fresh Seafood', 'rating' => 4.6, 'reviews_count' => 450, 'opening_hours' => '11:00 AM - 11:00 PM', 'description' => 'أسماك البحر الأحمر الطازجة والمحار المقلي مع إطلالة رائعة على يخوت بورت غالب.'],
            ['name' => 'Cousina Marsa Alam (كوزينا مرسى علم)', 'image' => '/images/restaurants/hurghada/gad.png', 'location' => 'Marsa Alam', 'cuisine' => 'Italian & Mediterranean', 'rating' => 4.8, 'reviews_count' => 250, 'opening_hours' => '01:00 PM - 11:30 PM', 'description' => 'مكرونة إيطالية بالسي فود وبيتزا على فرن الحطب بلمسة متوسطية راقية.'],

            // 9. Marsa Matrouh
            ['name' => 'Abou Sultan (أبو سلطان البدوية)', 'image' => '/images/restaurants/abousultan_bedouin_matrouh_1777148091166.png', 'location' => 'Marsa Matrouh', 'cuisine' => 'Bedouin Mansaf', 'rating' => 4.7, 'reviews_count' => 850, 'opening_hours' => '12:00 PM - 02:00 AM', 'description' => 'أكل واحاتي وبدوي مكمورة اللحم والمنسف البدوي في قعدات عربية أصيلة.'],
            ['name' => 'Corallo Matrouh (كورالو)', 'image' => '/images/restaurants/corallo_marsa_matrouh_1777148051600.png', 'location' => 'Marsa Matrouh', 'cuisine' => 'Italian Seafood & Pizza', 'rating' => 4.9, 'reviews_count' => 500, 'opening_hours' => '02:00 PM - 01:00 AM', 'description' => 'أطباق باستا السي فود والبيتزا الإيطالية الفاخرة بفيو البحر الفيروزي الخلاب.'],
            ['name' => 'Kamouna Seafood (كمونة للأسماك)', 'image' => '/images/restaurants/corallo_marsa_matrouh_1777148051600.png', 'location' => 'Marsa Matrouh', 'cuisine' => 'Fresh Coastal Fish', 'rating' => 4.6, 'reviews_count' => 750, 'opening_hours' => '11:00 AM - 12:00 AM', 'description' => 'أشهر مطبخ سمك في مطروح يقدم السمك المشوي بالردة والسي فود بخلطة واحاتية.'],

            // 10. Port Said
            ['name' => 'El Borg (مطعم البرج بورسعيد)', 'image' => '/images/restaurants/elborg_seafood_portsaid_1777148075142.png', 'location' => 'Port Said', 'cuisine' => 'Port Said Seafood', 'rating' => 4.8, 'reviews_count' => 1900, 'opening_hours' => '11:00 AM - 12:00 AM', 'description' => 'السيبيا والجمبري المفتوح والخلطات البورسعيدية.'],
            ['name' => 'Casten Port Said (كاستن البورسعيدي)', 'image' => '/images/restaurants/casten_masmat_portsaid_1777148104331.png', 'location' => 'Port Said', 'cuisine' => 'Masmat', 'rating' => 4.6, 'reviews_count' => 1100, 'opening_hours' => '12:00 PM - 03:00 AM', 'description' => 'كوارع، طحال، وممبار بورسعيدي حرش.'],
            ['name' => 'Daawa Sayadia (مطعم دعوة)', 'image' => '/images/restaurants/daawa_sayadia_portsaid_1777148035134.png', 'location' => 'Port Said', 'cuisine' => 'Sayadia & Home Cooking', 'rating' => 4.5, 'reviews_count' => 700, 'opening_hours' => '12:00 PM - 11:00 PM', 'description' => 'متخصص في الرز الصيادية البني والسمك المطبوخ.'],

            // 11. Fayoum
            ['name' => 'Ibis Tunis Village (إيبيس قرية تونس)', 'image' => '/images/restaurants/fayoum/ibis.png', 'location' => 'Fayoum', 'cuisine' => 'Falahi Breakfast', 'rating' => 4.9, 'reviews_count' => 400, 'opening_hours' => '08:00 AM - 06:00 PM', 'description' => 'فطار فلاحي - فطير مشلتت، مش، عسل، وجبن قريش من الفلاحين مباشرة.'],
            ['name' => 'Tunis Lake (تونس ليك)', 'image' => '/images/restaurants/tunislake_fayoum_v2_1777141870273.png', 'location' => 'Fayoum', 'cuisine' => 'Open Air Grills', 'rating' => 4.6, 'reviews_count' => 350, 'opening_hours' => '12:00 PM - 08:00 PM', 'description' => 'مشويات - كفتة وطرب في الهواء الطلق وسط الأشجار.'],
            ['name' => 'Qasr Rashwan (قصر رشوان للبط)', 'image' => '/images/restaurants/qasrrashwan_fayoum_v2_1777142156909.png', 'location' => 'Fayoum', 'cuisine' => 'Ducks & Pigeons', 'rating' => 4.8, 'reviews_count' => 600, 'opening_hours' => '01:00 PM - 10:00 PM', 'description' => 'ملك البط الفيومي المحشي والأرز بالخلطة والحمام المحشي فريك بلدي.']
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
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
