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
                'image' => '/images/museums/gem.jpg',
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
                'image' => '/images/museums/nmec.jpg',
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
                'image' => '/images/museums/karnak.jpg',
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
                'image' => '/images/museums/luxor-museum.jpg',
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
                'image' => '/images/museums/abu-simbel.jpg',
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
                'image' => '/images/museums/philae.jpg',
                'ticket_price' => 450,
                'opening_hours' => '7:00 صباحاً - 4:00 مساءً',
                'rating' => 4.8,
                'reviews_count' => 920,
                'highlights' => ['معبد إيزيس', 'كشك تراجان', 'عرض الصوت والضوء', 'رحلة بالقارب للجزيرة'],
            ],
            [
                'name' => 'المتحف اليوناني الروماني',
                'location' => 'الإسكندرية',
                'address' => 'شارع محمود مختار، الإسكندرية',
                'description' => 'أكبر متحف متخصص في الآثار اليونانية الرومانية في حوض البحر المتوسط، تم افتتاحه حديثاً بعد ترميم شامل.',
                'image' => '/images/museums/graeco-roman.jpg',
                'ticket_price' => 300,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.9,
                'reviews_count' => 300,
                'highlights' => ['تمثال الإسكندر الأكبر', 'فسيفساء ميدوسا', 'مجموعة التناجرا', 'الآثار البطلمية'],
            ],
            [
                'name' => 'قلعة قايتباي (متحف ومزار)',
                'location' => 'الإسكندرية',
                'address' => 'جزيرة فاروس، الإسكندرية',
                'description' => 'قلعة دفاعية مهيبة بُنيت على أنقاض فنار الإسكندرية القديم، توفر إطلالات ساحرة على البحر المتوسط.',
                'image' => '/images/museums/qaitbay.jpg',
                'ticket_price' => 150,
                'opening_hours' => '8:00 صباحاً - 5:00 مساءً',
                'rating' => 4.7,
                'reviews_count' => 1500,
                'highlights' => ['الأسوار الدفاعية', 'المسجد الأثري', 'السراديب', 'إطلالة البحر'],
            ],
            [
                'name' => 'متحف شرم الشيخ',
                'location' => 'شرم الشيخ',
                'address' => 'طريق السلام، شرم الشيخ',
                'description' => 'أول متحف للآثار في جنوب سيناء، يركز على أهمية البيئة والتجارة والتعايش السلمي في مصر القديمة.',
                'image' => '/images/museums/sharm-museum.jpg',
                'ticket_price' => 200,
                'opening_hours' => '10:00 صباحاً - 1:00 مساءً، 5:00 مساءً - 11:00 مساءً',
                'rating' => 4.6,
                'reviews_count' => 450,
                'highlights' => ['المسار الملكي', 'قاعة الحياة البرية', 'الآثار البدوية', 'المراكب الشمسية'],
            ],
            [
                'name' => 'متحف الغردقة',
                'location' => 'الغردقة',
                'address' => 'طريق المطار، الغردقة',
                'description' => 'يعرض الجمال والرفاهية في الحضارة المصرية عبر العصور، وهو أول متحف يبنى بالشراكة مع القطاع الخاص.',
                'image' => '/images/museums/hurghada-museum.jpg',
                'ticket_price' => 250,
                'opening_hours' => '10:00 صباحاً - 1:00 مساءً، 5:00 مساءً - 11:00 مساءً',
                'rating' => 4.7,
                'reviews_count' => 510,
                'highlights' => ['الآثار الذهبية', 'لوحات الفن الإسلامي', 'التماثيل الملكية', 'عرض الجمال والأزياء'],
            ],
        ];

        foreach ($data as $item) {
            Museum::create($item);
        }
    }
}
