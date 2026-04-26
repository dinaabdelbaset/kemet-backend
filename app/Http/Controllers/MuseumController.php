<?php

namespace App\Http\Controllers;

use App\Models\Museum;
use Illuminate\Http\Request;

class MuseumController extends Controller
{
    public function index()
    {
        if (Museum::count() === 0) {
            $this->seedMuseums();
        }

        return response()->json(Museum::all());
    }

    public function show($id)
    {
        $museum = Museum::find($id);
        if (!$museum) {
            return response()->json(['message' => 'Museum not found'], 404);
        }
        return response()->json($museum);
    }

    private function seedMuseums()
    {
        $data = [
            [
                'name' => 'المتحف المصري الكبير (GEM)',
                'location' => 'الجيزة',
                'address' => 'طريق القاهرة الإسكندرية الصحراوي، الجيزة',
                'description' => 'أكبر متحف أثري في العالم، يضم أكثر من 100 ألف قطعة أثرية بما في ذلك المجموعة الكاملة لكنوز الملك توت عنخ آمون.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/8/8a/Golden_mask_of_Tutankhamun.jpg',
                'ticket_price' => 1200,
                'opening_hours' => '9:00 صباحاً - 7:00 مساءً',
                'rating' => 4.9,
                'reviews_count' => 1250,
                'highlights' => ['مجموعة توت عنخ آمون', 'قاعة المومياوات الملكية', 'متحف مركب الشمس', 'تجربة الواقع الافتراضي'],
            ],
            [
                'name' => 'المتحف القومي للحضارة المصرية',
                'location' => 'القاهرة',
                'address' => 'عين الصيرة، مصر القديمة',
                'description' => 'موطن قاعة المومياوات الملكية، يتتبع هذا المتحف الحضارة المصرية من عصور ما قبل التاريخ حتى يومنا هذا.',
                'image' => 'https://images.unsplash.com/photo-1599839619722-39751411ea63?q=80&w=1000&auto=format&fit=crop',
                'ticket_price' => 500,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.8,
                'reviews_count' => 890,
                'highlights' => ['قاعة المومياوات الملكية', 'معرض ما قبل التاريخ', 'الجناح الإسلامي', 'قسم مصر الحديثة'],
            ],
            [
                'name' => 'مجمع معابد الكرنك',
                'location' => 'الأقصر',
                'address' => 'البر الشرقي، الأقصر',
                'description' => 'أكبر موقع ديني قديم في العالم، مخصص لثلاثي طيبة: آمون، موت، وخونسو.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/6/60/Temple_de_Louxor_68.jpg',
                'ticket_price' => 450,
                'opening_hours' => '6:00 صباحاً - 5:30 مساءً',
                'rating' => 4.9,
                'reviews_count' => 2100,
                'highlights' => ['صالة الأعمدة الكبرى', 'البحيرة المقدسة', 'طريق الكباش', 'عرض الصوت والضوء'],
            ],
            [
                'name' => 'متحف الأقصر',
                'location' => 'الأقصر',
                'address' => 'كورنيش النيل، الأقصر',
                'description' => 'متحف رائع يعرض قطعاً أثرية من منطقة طيبة، بما في ذلك التماثيل والمجوهرات والفخار من مختلف العصور المصرية.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/7/76/Luxor_Museum_1.JPG',
                'ticket_price' => 300,
                'opening_hours' => '9:00 صباحاً - 2:00 مساءً، 4:00 مساءً - 9:00 مساءً',
                'rating' => 4.7,
                'reviews_count' => 560,
                'highlights' => ['تماثيل توت عنخ آمون', 'معرض أمنحتب الثالث', 'آثار الدولة الحديثة', 'عرض المعدات العسكرية'],
            ],
            [
                'name' => 'معبدي أبو سمبل',
                'location' => 'أسوان',
                'address' => 'أبو سمبل، محافظة أسوان',
                'description' => 'معبدان صخريان ضخمان بناهما رمسيس الثاني، تم إنقاذهما من مياه بحيرة ناصر في إنجاز هندسي مذهل لمنظمة اليونسكو.',
                'image' => '/images/tours/abu_simbel.png',
                'ticket_price' => 600,
                'opening_hours' => '5:00 صباحاً - 6:00 مساءً',
                'rating' => 4.9,
                'reviews_count' => 1800,
                'highlights' => ['تعامد الشمس', 'معبد رمسيس الثاني العظيم', 'معبد نفرتاري', 'إطلالة بحيرة ناصر'],
            ],
            [
                'name' => 'معبد فيلة',
                'location' => 'أسوان',
                'address' => 'جزيرة أجيلكيا، أسوان',
                'description' => 'معبد إيزيس المذهل، تم نقله إلى جزيرة أجيلكيا بعد بناء السد العالي. تحفة من العمارة القديمة.',
                'image' => '/images/destinations/aswan/philae_light.png',
                'ticket_price' => 450,
                'opening_hours' => '7:00 صباحاً - 4:00 مساءً',
                'rating' => 4.8,
                'reviews_count' => 920,
                'highlights' => ['معبد إيزيس', 'كشك تراجان', 'عرض الصوت والضوء', 'رحلة بالقارب للجزيرة'],
            ],
            [
                'name' => 'المتحف المصري بالتحرير',
                'location' => 'القاهرة',
                'address' => 'ميدان التحرير، وسط البلد',
                'description' => 'أقدم متحف أثري في الشرق الأوسط، يضم مجموعة ضخمة من الآثار الفرعونية داخل مبناه التاريخي الأحمر المميز.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/3/33/1897_bis_1902_wurde_das_%C3%84gyptische_Museum_in_Kairo_gebaut._04.jpg',
                'ticket_price' => 450,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.8,
                'reviews_count' => 3200,
                'highlights' => ['كنوز يويا وتويا', 'قاعة المومياوات الحيوانية', 'تمثال خفرع', 'مجموعة العمارنة'],
            ],
            [
                'name' => 'متحف الفن الإسلامي',
                'location' => 'القاهرة',
                'address' => 'ميدان باب الخلق، القاهرة الإسلامية',
                'description' => 'أكبر متحف للفنون الإسلامية في العالم، يضم تحفاً نادرة من الخشب والجص والمعدن والخزف والزجاج.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/d/da/GD-EG-Caire-Mus%C3%A9eIslam001.JPG',
                'ticket_price' => 250,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.9,
                'reviews_count' => 850,
                'highlights' => ['المنابر الخشبية', 'المشكاوات الزجاجية', 'الأسلحة الإسلامية', 'المخطوطات النادرة'],
            ],
            [
                'name' => 'المتحف القبطي',
                'location' => 'القاهرة',
                'address' => 'مجمع الأديان، مصر القديمة',
                'description' => 'يضم أكبر مجموعة من الآثار القبطية في العالم، ويعرض تاريخ المسيحية في مصر داخل مبنى معماري مذهل.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/9/9c/Kairo_-_Altkairo_05.jpg',
                'ticket_price' => 200,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.7,
                'reviews_count' => 640,
                'highlights' => ['أيقونات قبطية', 'مخطوطات نجع حمادي', 'نسيج قبطي', 'أعمال خشبية مطعمة'],
            ],
            [
                'name' => 'متحف المجوهرات الملكية',
                'location' => 'الإسكندرية',
                'address' => 'زيزينيا، الإسكندرية',
                'description' => 'قصر فخم يعرض المقتنيات والمجوهرات الخاصة بالأسرة العلوية المالكة التي حكمت مصر، في عرض مبهر.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/f/f6/AlexRoyalJewelleryMusLeft.jpg',
                'ticket_price' => 300,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.8,
                'reviews_count' => 780,
                'highlights' => ['تاج الملكة فريدة', 'مجوهرات الأميرات', 'شطرنج من الذهب', 'الزجاج المعشق للقصر'],
            ],
            [
                'name' => 'متحف الإسكندرية القومي',
                'location' => 'الإسكندرية',
                'address' => 'شارع طريق الحرية، الإسكندرية',
                'description' => 'قصر إيطالي الطراز يحكي قصة مدينة الإسكندرية عبر العصور الفرعونية، اليونانية الرومانية، القبطية، والإسلامية.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/d/da/GD-EG-Alex-Mus%C3%A9eNat040.JPG',
                'ticket_price' => 250,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.6,
                'reviews_count' => 520,
                'highlights' => ['آثار غارقة', 'تماثيل يونانية', 'عملات بطلمية', 'آثار إسلامية'],
            ],
            [
                'name' => 'متحف التحنيط',
                'location' => 'الأقصر',
                'address' => 'كورنيش النيل، الأقصر',
                'description' => 'متحف فريد مخصص لشرح عملية التحنيط عند الفراعنة، ويعرض أدوات التحنيط ومومياوات لحيوانات مقدسة.',
                'image' => 'https://images.unsplash.com/photo-1544148103-0773bf10d330?q=80&w=600',
                'ticket_price' => 150,
                'opening_hours' => '9:00 صباحاً - 1:00 مساءً، 5:00 مساءً - 9:00 مساءً',
                'rating' => 4.5,
                'reviews_count' => 410,
                'highlights' => ['أدوات التحنيط', 'مومياوات حيوانية', 'سرير التحنيط', 'تمثال أنوبيس'],
            ],
            [
                'name' => 'متحف النوبة',
                'location' => 'أسوان',
                'address' => 'طريق الفنادق، أسوان',
                'description' => 'متحف حائز على جوائز يعرض تاريخ وثقافة النوبة منذ عصور ما قبل التاريخ حتى بناء السد العالي.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/7/77/Aswan_Nubian_Museum_entrance.jpg',
                'ticket_price' => 200,
                'opening_hours' => '9:00 صباحاً - 1:00 مساءً، 5:00 مساءً - 9:00 مساءً',
                'rating' => 4.8,
                'reviews_count' => 950,
                'highlights' => ['تمثال رمسيس الثاني', 'ديوراما الحياة النوبية', 'آثار غارقة تم إنقاذها', 'قرية نوبية مصغرة'],
            ],
            [
                'name' => 'المتحف اليوناني الروماني',
                'location' => 'الإسكندرية',
                'address' => 'شارع محمود مختار، الإسكندرية',
                'description' => 'أكبر متحف متخصص في الآثار اليونانية الرومانية في حوض البحر المتوسط، تم افتتاحه حديثاً بعد ترميم شامل.',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/3/3d/Fassade_des_griechisch-r%C3%B6mischen_Museums_in_Alexandria%2C_%C3%84gypten.jpg',
                'ticket_price' => 300,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.9,
                'reviews_count' => 300,
                'highlights' => ['تمثال الإسكندر الأكبر', 'فسيفساء ميدوسا', 'مجموعة التناجرا', 'الآثار البطلمية'],
            ],
        ];

        foreach ($data as $item) {
            Museum::create($item);
        }
    }
}
