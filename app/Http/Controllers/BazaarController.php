<?php

namespace App\Http\Controllers;

use App\Models\Bazaar;
use Illuminate\Http\Request;

class BazaarController extends Controller
{
    public function index()
    {
        if (Bazaar::count() === 0) {
            $this->seedBazaars();
        }
        return response()->json(Bazaar::all());
    }

    private function seedBazaars()
    {
        $data = [
            // CAIRO
            [
                'title' => 'Khan El Khalili',
                'location' => 'القاهرة',
                'image' => '/images/bazaars/khan-el-khalili.jpg',
                'description' => 'أشهر سوق سياحي في مصر والشرق الأوسط، يتميز بالأزقة التاريخية، المشغولات الفضية والنحاسية، والفوانيس الملونة.',
                'specialty' => ['فضيات', 'نحاسيات', 'هدايا تذكارية', 'عطور'],
            ],
            [
                'title' => 'Souq El Fustat',
                'location' => 'القاهرة',
                'image' => 'https://images.unsplash.com/photo-1577083654400-3cb83fc35151?q=80&w=1000&auto=format&fit=crop',
                'description' => 'مركز متخصص في الحرف اليدوية المصرية الأصيلة كالفخار، الخزف، الزجاج المعشق، والخيامية في منطقة مصر القديمة.',
                'specialty' => ['فخار', 'خزف', 'خيامية', 'مشغولات يدوية'],
            ],
            [
                'title' => 'Wekalet El Balah Market',
                'location' => 'القاهرة',
                'image' => 'https://images.unsplash.com/photo-1520698947600-47b2c01d4a04?q=80&w=1000&auto=format&fit=crop',
                'description' => 'سوق تاريخي شهير على ضفاف النيل يزوره السياح للبحث عن الأقمشة النادرة، المنسوجات، والملابس الكلاسيكية.',
                'specialty' => ['أقمشة', 'ملابس عتيقة', 'منسوجات', 'جلود'],
            ],
            // GIZA
            [
                'title' => 'Giza Pyramids Bazaar',
                'location' => 'الجيزة',
                'image' => 'https://images.unsplash.com/photo-1531604250646-2f0e818c4f06?q=80&w=1000&auto=format&fit=crop',
                'description' => 'مجموعة من البازارات المحيطة بمنطقة الأهرامات، تقدم تماثيل فرعونية وتذكارات سياحية للزوار.',
                'specialty' => ['تماثيل فرعونية', 'أهرامات مصغرة', 'تيشيرتات قطنية', 'هدايا تذكارية'],
            ],
            [
                'title' => 'Papyrus Institute',
                'location' => 'الجيزة',
                'image' => 'https://images.unsplash.com/photo-1563840742139-2a912bbbc28d?q=80&w=1000&auto=format&fit=crop',
                'description' => 'معرض رسمي معتمد يعرض لوحات أصلية مرسومة باليد على ورق البردي، تحكي قصص الفراعنة والآلهة القديمة.',
                'specialty' => ['ورق بردي أصلي', 'رسم هيروغليفي', 'علامات كتب', 'لوحات فنية'],
            ],
            [
                'title' => 'Golden Eagle Papyrus',
                'location' => 'الجيزة',
                'image' => 'https://images.unsplash.com/photo-1558500201-d70313531b26?q=80&w=1000&auto=format&fit=crop',
                'description' => 'من أشهر معارض ورق البردي المعتمدة التي يزورها السياح لشراء الأعمال الفنية المضيئة في الظلام.',
                'specialty' => ['برديات مضيئة', 'شهادات توثيق', 'هدايا ملكية', 'رسم شخصي'],
            ],
            // ALEXANDRIA
            [
                'title' => 'Attarine Market',
                'location' => 'الإسكندرية',
                'image' => 'https://images.unsplash.com/photo-1550580970-17933ab371de?q=80&w=1000&auto=format&fit=crop',
                'description' => 'سوق الإسكندرية الأثري الشهير، المتخصص في بيع التحف، الأنتيكات، الأثاث الكلاسيكي، والمقتنيات القديمة النادرة.',
                'specialty' => ['تحف وأنتيكات', 'أثاث كلاسيكي', 'مقتنيات قديمة', 'كتب نادرة'],
            ],
            [
                'title' => 'Souq El Gomaa Alexandria',
                'location' => 'الإسكندرية',
                'image' => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?q=80&w=1000&auto=format&fit=crop',
                'description' => 'سوق محلي مفتوح يعرض كل شيء من العملات القديمة إلى الطوابع والمشغولات النحاسية، وجهة ممتازة للبحث عن الكنوز.',
                'specialty' => ['عملات قديمة', 'طوابع', 'خردوات', 'نحاسيات'],
            ],
            [
                'title' => 'Stanley Souvenir Shops',
                'location' => 'الإسكندرية',
                'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?q=80&w=1000&auto=format&fit=crop',
                'description' => 'متاجر سياحية راقية على كورنيش ستانلي تبيع المشغولات البحرية، القواقع، وهدايا تذكارية بطابع بحري سكندري.',
                'specialty' => ['قواقع بحرية', 'مشغولات يدوية', 'هدايا بحرية', 'ملابس صيفية'],
            ],
            // LUXOR
            [
                'title' => 'Luxor Souq',
                'location' => 'الأقصر',
                'image' => '/images/bazaars/luxor-souq.jpg',
                'description' => 'شارع سياحي طويل مخصص للمشاة، يضم مئات البازارات التي تبيع الملابس القطنية، التوابل، والمصنوعات الجلدية.',
                'specialty' => ['قطنيات', 'توابل', 'تماثيل', 'مجوهرات'],
            ],
            [
                'title' => 'Habiba Gallery',
                'location' => 'الأقصر',
                'image' => 'https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3?q=80&w=1000&auto=format&fit=crop',
                'description' => 'معرض شهير يبيع مشغولات يدوية مصرية أصلية وعالية الجودة من صعيد مصر، يتم إنتاجها بواسطة نساء محليات.',
                'specialty' => ['نسيج يدوي', 'مجوهرات تراثية', 'حقائب مطرزة', 'شيلان'],
            ],
            [
                'title' => 'Alabaster Factory Luxor',
                'location' => 'الأقصر',
                'image' => 'https://images.unsplash.com/photo-1601058268499-e52658b8ebf8?q=80&w=1000&auto=format&fit=crop',
                'description' => 'مصانع بالبر الغربي تقدم عروضاً حية لنحت المرمر بالطريقة الفرعونية، وتبيع تحفاً فنية مذهلة.',
                'specialty' => ['تماثيل مرمر', 'أواني ألباستر مضيئة', 'منحوتات', 'جعارين'],
            ],
            // ASWAN
            [
                'title' => 'Aswan Souq',
                'location' => 'أسوان',
                'image' => '/images/bazaars/aswan-spice.jpg',
                'description' => 'بازار أسوان الرئيسي الغني بالألوان، مشهور ببيع الكركديه، الفول السوداني الأسواني، التوابل، والعطور الطبيعية.',
                'specialty' => ['كركديه أسواني', 'توابل', 'عطور خام', 'فول سوداني'],
            ],
            [
                'title' => 'Nubian Bazaar',
                'location' => 'أسوان',
                'image' => 'https://images.unsplash.com/photo-1604608688402-23cfa0102604?q=80&w=1000&auto=format&fit=crop',
                'description' => 'يقع في القرى النوبية على ضفاف النيل، يعرض مشغولات الخوص الملونة، القبعات النوبية، والأقنعة الخشبية.',
                'specialty' => ['مشغولات خوص', 'قبعات نوبية', 'أقنعة خشبية', 'إكسسوارات'],
            ],
            [
                'title' => 'Sharia Market Aswan',
                'location' => 'أسوان',
                'image' => 'https://images.unsplash.com/photo-1518655048521-f130df041f66?q=80&w=1000&auto=format&fit=crop',
                'description' => 'بازار مفتوح بمحاذاة النيل يوفر المشغولات الجلدية، التماثيل الأفريقية، والمنتجات اليدوية التراثية.',
                'specialty' => ['جلود', 'تماثيل أفريقية', 'حرف نوبية', 'سبح خشبية'],
            ],
            // SHARM EL SHEIKH
            [
                'title' => 'Old Market Sharm',
                'location' => 'شرم الشيخ',
                'image' => '/images/bazaars/sharm-old-market.jpg',
                'description' => 'المنطقة الأكثر حيوية للتسوق، بجوار مسجد الصحابة. يضم بازارات تبيع الهدايا التذكارية، التوابل، والأعشاب السيناوية.',
                'specialty' => ['أعشاب سيناوية', 'هدايا تذكارية', 'مصابيح ملونة', 'ملابس قطنية'],
            ],
            [
                'title' => 'SOHO Square Shops',
                'location' => 'شرم الشيخ',
                'image' => 'https://images.unsplash.com/photo-1555529771-835f59fc5efe?q=80&w=1000&auto=format&fit=crop',
                'description' => 'متاجر سياحية راقية في سوهو سكوير، توفر تسوقاً فاخراً للهدايا التذكارية، المجوهرات، والماركات العالمية.',
                'specialty' => ['مجوهرات راقية', 'ملابس', 'عطور', 'تذكارات فاخرة'],
            ],
            [
                'title' => 'Naama Bay Market',
                'location' => 'شرم الشيخ',
                'image' => 'https://images.unsplash.com/photo-1533900298318-6b8da08a523e?q=80&w=1000&auto=format&fit=crop',
                'description' => 'أسواق حيوية ليلية في قلب خليج نعمة، توفر كل شيء من المشغولات اليدوية إلى مستلزمات الغوص.',
                'specialty' => ['مستلزمات غوص', 'أعمال يدوية', 'تيشيرتات مطبوعة', 'نظارات شمسية'],
            ],
            // HURGHADA
            [
                'title' => 'El Dahar Bazaar',
                'location' => 'الغردقة',
                'image' => '/images/bazaars/el-dahar-souq.jpg',
                'description' => 'السوق المحلي الأقدم في الغردقة، مكان مثالي لشراء الخضراوات الطازجة، الفواكه الاستوائية، والتوابل الأصيلة.',
                'specialty' => ['فواكه استوائية', 'توابل', 'أطعمة بحرية', 'مشغولات محلية'],
            ],
            [
                'title' => 'Sheraton Street Shops',
                'location' => 'الغردقة',
                'image' => 'https://images.unsplash.com/photo-1519642918688-7e43b19245d8?q=80&w=1000&auto=format&fit=crop',
                'description' => 'الشارع السياحي الأهم في الغردقة، يمتلئ بالبازارات التي تعرض الملابس الصيفية، التذكارات، والزيوت العطرية.',
                'specialty' => ['ملابس صيفية', 'تذكارات بحرية', 'زيوت طبيعية', 'حقائب جلدية'],
            ],
            [
                'title' => 'Senzo Mall Souvenirs',
                'location' => 'الغردقة',
                'image' => 'https://images.unsplash.com/photo-1519567281799-97120703e2db?q=80&w=1000&auto=format&fit=crop',
                'description' => 'متاجر هدايا مكيفة داخل أكبر مول في الغردقة، تقدم أسعاراً ثابتة وتجربة تسوق مريحة للسياح.',
                'specialty' => ['تذكارات فرعونية', 'مستحضرات تجميل', 'مجوهرات', 'ملابس'],
            ],
            // MARSA ALAM
            [
                'title' => 'Marsa Alam Souvenir Shops',
                'location' => 'مرسى علم',
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1000&auto=format&fit=crop',
                'description' => 'محلات صغيرة في الفنادق والقرى السياحية تبيع المشغولات البحرية والقمصان القطنية المطبوعة.',
                'specialty' => ['مشغولات بحرية', 'ملابس غوص', 'تيشيرتات مطبوعة', 'زيوت مساج'],
            ],
            [
                'title' => 'Port Ghalib Bazaar',
                'location' => 'مرسى علم',
                'image' => 'https://images.unsplash.com/photo-1568297753763-8a032d8bf429?q=80&w=1000&auto=format&fit=crop',
                'description' => 'ممشى سياحي راقٍ يطل على المارينا، يضم بازارات فاخرة تبيع المشغولات اليدوية والتوابل والمجوهرات.',
                'specialty' => ['مجوهرات راقية', 'تحف', 'ملابس فاخرة', 'توابل ممتازة'],
            ],
            [
                'title' => 'Bedouin Market Marsa Alam',
                'location' => 'مرسى علم',
                'image' => '/images/bazaars/assalah-square.jpg',
                'description' => 'سوق تراثي يعرض مشغولات القبائل البدوية الأصلية مثل الأساور الخرزية، الأعشاب الجبلية، والسجاد اليدوي.',
                'specialty' => ['إكسسوارات خرز', 'أعشاب جبلية', 'سجاد بدوي', 'شاي بدوي'],
            ],
            // MARSA MATROUH
            [
                'title' => 'Matrouh Local Market',
                'location' => 'مرسى مطروح',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1000&auto=format&fit=crop',
                'description' => 'الوجهة الأهم لشراء منتجات الصحراء الغربية مثل البطيخ المطروحي، النعناع الجبلي، وزيت الزيتون البكر.',
                'specialty' => ['نعناع جبلي', 'زيت زيتون', 'تمر مطروحي', 'أعشاب صحراوية'],
            ],
            [
                'title' => 'Libyan Market Matrouh',
                'location' => 'مرسى مطروح',
                'image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=1000&auto=format&fit=crop',
                'description' => 'بازار شهير متأثر بالثقافة الليبية القريبة، يبيع الملابس البدوية، الأحذية الجلدية، والأعشاب النادرة.',
                'specialty' => ['ملابس بدوية', 'أحذية جلدية', 'أقمشة', 'أعشاب بدوية'],
            ],
            [
                'title' => 'Rommel Market',
                'location' => 'مرسى مطروح',
                'image' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?q=80&w=1000&auto=format&fit=crop',
                'description' => 'سوق صيفي مفعم بالحيوية بالقرب من شاطئ روميل، يوفر ملابس البحر، ألعاب الأطفال، وتذكارات الإجازات الصيفية.',
                'specialty' => ['مستلزمات شاطئ', 'ملابس صيفية', 'ألعاب بحرية', 'هدايا بسيطة'],
            ],
            // PORT SAID
            [
                'title' => 'Port Said Bazaar',
                'location' => 'بورسعيد',
                'image' => 'https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?q=80&w=1000&auto=format&fit=crop',
                'description' => 'بازار تاريخي يمتاز بالعمارة الخشبية الأوروبية، يبيع البضائع المستوردة والملابس بأسعار تنافسية.',
                'specialty' => ['ملابس مستوردة', 'شيكولاتة', 'عطور', 'حقائب'],
            ],
            [
                'title' => 'Free Zone Market Port Said',
                'location' => 'بورسعيد',
                'image' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=1000&auto=format&fit=crop',
                'description' => 'السوق التجاري الأكبر في المدينة، يعتمد عليه الزوار لشراء العلامات التجارية العالمية بدون جمارك.',
                'specialty' => ['أجهزة كهربائية', 'ملابس ماركات', 'أحذية رياضية', 'عطور مستوردة'],
            ],
            [
                'title' => 'Al Arab District Shops',
                'location' => 'بورسعيد',
                'image' => 'https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?q=80&w=1000&auto=format&fit=crop',
                'description' => 'الأسواق الشعبية الأصلية للمدينة، تقدم المأكولات البحرية الطازجة والمنتجات المحلية بأجواء مصرية دافئة.',
                'specialty' => ['مأكولات بحرية', 'حلويات بورسعيدية', 'ملابس محلية', 'توابل'],
            ],
            // FAYOUM
            [
                'title' => 'Fayoum Souq',
                'location' => 'الفيوم',
                'image' => 'https://images.unsplash.com/photo-1533900298318-6b8da08a523e?q=80&w=1000&auto=format&fit=crop',
                'description' => 'السوق الرئيسي للمحافظة، يشتهر ببيع منتجات السعف، سلال الخوص الملونة، والمنتجات الزراعية الريفية.',
                'specialty' => ['مشغولات خوص', 'سلال سعف', 'عسل نحل', 'منتجات زراعية'],
            ],
            [
                'title' => 'Tunis Village Shops',
                'location' => 'الفيوم',
                'image' => '/images/bazaars/shali-market.jpg',
                'description' => 'الوجهة السياحية الفنية الأولى في الفيوم، تتميز بمعارض الخزف والفخار اليدوي ذو التصميمات المستوحاة من الطبيعة.',
                'specialty' => ['خزف فني', 'فخار يدوي', 'أكواب ملونة', 'لوحات فخارية'],
            ],
            [
                'title' => 'Qarun Lake Bazaar',
                'location' => 'الفيوم',
                'image' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=1000&auto=format&fit=crop',
                'description' => 'بازارات صغيرة على ضفاف البحيرة تقدم الأسماك المملحة والتذكارات الريفية البسيطة لزوار الفيوم.',
                'specialty' => ['هدايا ريفية', 'مشغولات فخارية', 'أسماك بحيرة', 'طيور زينة'],
            ]
        ];

        foreach ($data as $item) {
            Bazaar::create($item);
        }
    }

    public function show($id)
    {
        $bazaar = Bazaar::find($id);
        if (!$bazaar) {
            return response()->json(['message' => 'Bazaar not found'], 404);
        }
        return response()->json($bazaar);
    }
}
