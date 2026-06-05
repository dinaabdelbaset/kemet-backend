<?php

namespace App\Http\Controllers;

use App\Models\Museum;
use Illuminate\Http\Request;

class MuseumController extends Controller
{
    public function index()
    {
        // Re-seed with new 33 items
        if (Museum::count() !== 33) {
            Museum::truncate();
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
            // Cairo (القاهرة)
            [
                'name' => 'المتحف القومي للحضارة المصرية',
                'location' => 'Cairo',
                'address' => 'عين الصيرة، الفسطاط، القاهرة',
                'description' => 'متحف يضم آثاراً من عصور مختلفة ويوثق الحضارة المصرية، يشتهر بقاعة المومياوات الملكية.',
                'image' => '/images/museums/nmec.jpg',
                'ticket_price' => 500,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.8,
                'reviews_count' => 890,
                'highlights' => ['قاعة المومياوات الملكية', 'معرض ما قبل التاريخ', 'الجناح الإسلامي'],
            ],
            [
                'name' => 'المتحف المصري بالتحرير',
                'location' => 'Cairo',
                'address' => 'ميدان التحرير، القاهرة',
                'description' => 'أقدم متحف أثري في الشرق الأوسط يضم أكبر مجموعة من الآثار الفرعونية.',
                'image' => '/images/museums/egyptian-museum.jpg',
                'ticket_price' => 450,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.7,
                'reviews_count' => 2300,
                'highlights' => ['كنوز توت عنخ آمون', 'قاعة المومياوات', 'مجموعة يويا وثويا'],
            ],
            [
                'name' => 'متحف الفن الإسلامي',
                'location' => 'Cairo',
                'address' => 'ميدان باب الخلق، القاهرة',
                'description' => 'أكبر متحف إسلامي بالعالم يضم مجموعات نادرة من الفنون الإسلامية من مختلف العصور.',
                'image' => '/images/museums/islamic-art.jpg',
                'ticket_price' => 300,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.9,
                'reviews_count' => 600,
                'highlights' => ['المخطوطات النادرة', 'السجاد الأثري', 'الأسلحة الإسلامية'],
            ],

            // Giza (الجيزة)
            [
                'name' => 'المتحف المصري الكبير (GEM)',
                'location' => 'Giza',
                'address' => 'طريق القاهرة الإسكندرية الصحراوي، الجيزة',
                'description' => 'أكبر متحف أثري في العالم، يضم أكثر من 100 ألف قطعة أثرية بما في ذلك المجموعة الكاملة لكنوز توت عنخ آمون.',
                'image' => '/images/museums/gem.jpg',
                'ticket_price' => 1200,
                'opening_hours' => '9:00 صباحاً - 7:00 مساءً',
                'rating' => 4.9,
                'reviews_count' => 1250,
                'highlights' => ['مجموعة توت عنخ آمون', 'الدرج العظيم', 'تمثال رمسيس الثاني'],
            ],
            [
                'name' => 'متحف مركب خوفو',
                'location' => 'Giza',
                'address' => 'منطقة أهرامات الجيزة',
                'description' => 'متحف يضم أقدم سفينة سليمة في العالم، وهي مركب الشمس للملك خوفو.',
                'image' => '/images/museums/khufu-boat.jpg',
                'ticket_price' => 200,
                'opening_hours' => '8:00 صباحاً - 4:00 مساءً',
                'rating' => 4.6,
                'reviews_count' => 800,
                'highlights' => ['مركب الشمس', 'تاريخ الملاحة الفرعونية', 'قطع الخشب الأصلية'],
            ],
            [
                'name' => 'متحف طه حسين',
                'location' => 'Giza',
                'address' => 'شارع حلمي، الهرم، الجيزة',
                'description' => 'فيلا عميد الأدب العربي طه حسين التي تم تحويلها إلى متحف يضم مقتنياته الشخصية ومكتبته.',
                'image' => '/images/museums/taha-hussein.jpg',
                'ticket_price' => 50,
                'opening_hours' => '9:00 صباحاً - 2:00 مساءً',
                'rating' => 4.5,
                'reviews_count' => 200,
                'highlights' => ['مكتبة طه حسين', 'النياشين والأوسمة', 'المقتنيات الشخصية'],
            ],

            // Alexandria (الإسكندرية)
            [
                'name' => 'المتحف اليوناني الروماني',
                'location' => 'Alexandria',
                'address' => 'شارع محمود مختار، الإسكندرية',
                'description' => 'أكبر متحف متخصص في الآثار اليونانية الرومانية في حوض البحر المتوسط.',
                'image' => '/images/museums/graeco-roman.jpg',
                'ticket_price' => 300,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.9,
                'reviews_count' => 300,
                'highlights' => ['تمثال الإسكندر الأكبر', 'فسيفساء ميدوسا', 'الآثار البطلمية'],
            ],
            [
                'name' => 'قلعة قايتباي',
                'location' => 'Alexandria',
                'address' => 'جزيرة فاروس، الإسكندرية',
                'description' => 'قلعة دفاعية مهيبة بُنيت على أنقاض فنار الإسكندرية القديم، وتحتوي على متحف بحري صغير.',
                'image' => '/images/museums/qaitbay.jpg',
                'ticket_price' => 150,
                'opening_hours' => '8:00 صباحاً - 5:00 مساءً',
                'rating' => 4.7,
                'reviews_count' => 1500,
                'highlights' => ['الأسوار الدفاعية', 'إطلالة البحر', 'المتحف البحري'],
            ],
            [
                'name' => 'متحف المجوهرات الملكية',
                'location' => 'Alexandria',
                'address' => 'حي زيزينيا، الإسكندرية',
                'description' => 'قصر فخم يعرض مجوهرات ومقتنيات الأسرة العلوية المالكة لمصر.',
                'image' => '/images/museums/royal-jewelry.jpg',
                'ticket_price' => 250,
                'opening_hours' => '9:00 صباحاً - 4:00 مساءً',
                'rating' => 4.8,
                'reviews_count' => 700,
                'highlights' => ['تاج الأميرة شويكار', 'مجوهرات الملك فاروق', 'اللوحات الزيتية'],
            ],

            // Luxor (الأقصر)
            [
                'name' => 'متحف الأقصر',
                'location' => 'Luxor',
                'address' => 'كورنيش النيل، الأقصر',
                'description' => 'متحف رائع يعرض قطعاً أثرية من منطقة طيبة، بما في ذلك التماثيل والمجوهرات.',
                'image' => '/images/museums/luxor-museum.jpg',
                'ticket_price' => 300,
                'opening_hours' => '9:00 صباحاً - 9:00 مساءً',
                'rating' => 4.7,
                'reviews_count' => 560,
                'highlights' => ['تماثيل توت عنخ آمون', 'معرض أمنحتب الثالث', 'مومياوات ملكية'],
            ],
            [
                'name' => 'متحف التحنيط',
                'location' => 'Luxor',
                'address' => 'كورنيش النيل، الأقصر',
                'description' => 'متحف فريد مخصص لفن التحنيط المصري القديم يشرح العملية بالكامل.',
                'image' => '/images/museums/mummification-museum.jpg',
                'ticket_price' => 200,
                'opening_hours' => '9:00 صباحاً - 9:00 مساءً',
                'rating' => 4.6,
                'reviews_count' => 400,
                'highlights' => ['أدوات التحنيط', 'مومياوات حيوانية', 'سرير التحنيط'],
            ],
            [
                'name' => 'مجمع معابد الكرنك (متحف مفتوح)',
                'location' => 'Luxor',
                'address' => 'البر الشرقي، الأقصر',
                'description' => 'أكبر متحف مفتوح وموقع ديني قديم في العالم.',
                'image' => '/images/museums/karnak.jpg',
                'ticket_price' => 450,
                'opening_hours' => '6:00 صباحاً - 5:30 مساءً',
                'rating' => 4.9,
                'reviews_count' => 2100,
                'highlights' => ['صالة الأعمدة الكبرى', 'البحيرة المقدسة', 'طريق الكباش'],
            ],

            // Aswan (أسوان)
            [
                'name' => 'متحف النوبة',
                'location' => 'Aswan',
                'address' => 'شارع الفنادق، أسوان',
                'description' => 'متحف يوثق تاريخ وحضارة بلاد النوبة الممتد لآلاف السنين.',
                'image' => '/images/museums/nubian-museum.jpg',
                'ticket_price' => 250,
                'opening_hours' => '9:00 صباحاً - 1:00 مساءً, 5:00 مساءً - 9:00 مساءً',
                'rating' => 4.8,
                'reviews_count' => 900,
                'highlights' => ['الآثار النوبية', 'الحديقة النباتية للمتحف', 'نموذج البيت النوبي'],
            ],
            [
                'name' => 'متحف النيل',
                'location' => 'Aswan',
                'address' => 'طريق السد العالي، أسوان',
                'description' => 'متحف يوثق تاريخ نهر النيل والمشاريع القومية المتعلقة به.',
                'image' => '/images/museums/nile-museum.jpg',
                'ticket_price' => 100,
                'opening_hours' => '9:00 صباحاً - 9:00 مساءً',
                'rating' => 4.5,
                'reviews_count' => 300,
                'highlights' => ['تاريخ السد العالي', 'تراث دول حوض النيل', 'لوحات فنية'],
            ],
            [
                'name' => 'معبدي أبو سمبل (متحف مفتوح)',
                'location' => 'Aswan',
                'address' => 'أبو سمبل، أسوان',
                'description' => 'معبدان صخريان ضخمان بناهما رمسيس الثاني، يعتبران متحفاً مفتوحاً للفن والعمارة.',
                'image' => '/images/museums/abu-simbel.jpg',
                'ticket_price' => 600,
                'opening_hours' => '5:00 صباحاً - 6:00 مساءً',
                'rating' => 4.9,
                'reviews_count' => 1800,
                'highlights' => ['معبد رمسيس', 'معبد نفرتاري', 'تعامد الشمس'],
            ],

            // Sharm El-Sheikh (شرم الشيخ)
            [
                'name' => 'متحف شرم الشيخ',
                'location' => 'Sharm El-Sheikh',
                'address' => 'طريق السلام، شرم الشيخ',
                'description' => 'أول متحف للآثار في جنوب سيناء، يركز على أهمية البيئة والتعايش السلمي في مصر القديمة.',
                'image' => '/images/museums/sharm-museum.jpg',
                'ticket_price' => 200,
                'opening_hours' => '10:00 صباحاً - 11:00 مساءً',
                'rating' => 4.6,
                'reviews_count' => 450,
                'highlights' => ['المسار الملكي', 'قاعة الحياة البرية', 'الآثار البدوية'],
            ],
            [
                'name' => 'متحف كينج توت',
                'location' => 'Sharm El-Sheikh',
                'address' => 'خليج نعمة، شرم الشيخ',
                'description' => 'متحف يعرض نسخاً طبق الأصل من كنوز توت عنخ آمون.',
                'image' => '/images/museums/king-tut-sharm.jpg',
                'ticket_price' => 150,
                'opening_hours' => '10:00 صباحاً - 12:00 منتصف الليل',
                'rating' => 4.3,
                'reviews_count' => 200,
                'highlights' => ['القناع الذهبي المستنسخ', 'العجلة الحربية', 'السرير الذهبي'],
            ],
            [
                'name' => 'متحف البرديات',
                'location' => 'Sharm El-Sheikh',
                'address' => 'السوق القديم، شرم الشيخ',
                'description' => 'متحف صغير يعرض فن صناعة ورق البردي واللوحات الفنية الفرعونية المذهلة.',
                'image' => '/images/museums/papyrus-sharm.jpg',
                'ticket_price' => 50,
                'opening_hours' => '9:00 صباحاً - 10:00 مساءً',
                'rating' => 4.4,
                'reviews_count' => 150,
                'highlights' => ['صناعة البردي', 'لوحات فنية', 'كتابة الأسماء بالهيروغليفية'],
            ],

            // Hurghada (الغردقة)
            [
                'name' => 'متحف الغردقة',
                'location' => 'Hurghada',
                'address' => 'طريق المطار، الغردقة',
                'description' => 'أول متحف يبنى بالشراكة مع القطاع الخاص ويعرض الجمال والرفاهية في الحضارة المصرية.',
                'image' => '/images/museums/hurghada-museum.jpg',
                'ticket_price' => 250,
                'opening_hours' => '10:00 صباحاً - 11:00 مساءً',
                'rating' => 4.7,
                'reviews_count' => 510,
                'highlights' => ['الآثار الذهبية', 'التماثيل الملكية', 'مجموعة الفن الإسلامي'],
            ],
            [
                'name' => 'متحف الرمال (Sand City)',
                'location' => 'Hurghada',
                'address' => 'طريق سفاجا، الغردقة',
                'description' => 'متحف مفتوح يضم تماثيل رملية ضخمة لشخصيات أسطورية وتاريخية.',
                'image' => '/images/museums/sand-museum.jpg',
                'ticket_price' => 300,
                'opening_hours' => '8:00 صباحاً - 6:00 مساءً',
                'rating' => 4.5,
                'reviews_count' => 800,
                'highlights' => ['التماثيل التاريخية', 'شخصيات ديزني', 'ورش عمل للأطفال'],
            ],
            [
                'name' => 'متحف الأحياء المائية (الجراند أكواريوم)',
                'location' => 'Hurghada',
                'address' => 'طريق القرى، الغردقة',
                'description' => 'متحف يعرض الكائنات البحرية لبيئة البحر الأحمر في أحواض زجاجية ضخمة.',
                'image' => '/images/museums/hurghada-aquarium.jpg',
                'ticket_price' => 500,
                'opening_hours' => '9:00 صباحاً - 7:00 مساءً',
                'rating' => 4.8,
                'reviews_count' => 1500,
                'highlights' => ['نفق أسماك القرش', 'الغابات المطيرة', 'وادي الحفريات'],
            ],

            // Marsa Alam (مرسى علم)
            [
                'name' => 'متحف الحياة البحرية',
                'location' => 'Marsa Alam',
                'address' => 'بورت غالب، مرسى علم',
                'description' => 'متحف مخصص لتوعية الزوار بالبيئة البحرية النادرة في مرسى علم وتاريخ الغوص.',
                'image' => '/images/museums/marine-life.jpg',
                'ticket_price' => 100,
                'opening_hours' => '10:00 صباحاً - 8:00 مساءً',
                'rating' => 4.4,
                'reviews_count' => 120,
                'highlights' => ['هياكل الكائنات البحرية', 'تاريخ بورت غالب', 'أدوات الغوص الكلاسيكية'],
            ],
            [
                'name' => 'متحف التراث البدوي',
                'location' => 'Marsa Alam',
                'address' => 'وادي الجمال، مرسى علم',
                'description' => 'متحف ثقافي يجسد حياة قبائل العبابدة والبشارية وعاداتهم التراثية.',
                'image' => '/images/museums/bedouin-heritage.jpg',
                'ticket_price' => 150,
                'opening_hours' => '8:00 صباحاً - 5:00 مساءً',
                'rating' => 4.6,
                'reviews_count' => 250,
                'highlights' => ['الأزياء التقليدية', 'أدوات القهوة البدوية', 'الموسيقى التراثية'],
            ],
            [
                'name' => 'متحف التعدين والتاريخ الجيولوجي',
                'location' => 'Marsa Alam',
                'address' => 'طريق إدفو، مرسى علم',
                'description' => 'معرض يوثق تاريخ استخراج الذهب والزمرد من الصحراء الشرقية منذ العصر الفرعوني.',
                'image' => '/images/museums/geology-museum.jpg',
                'ticket_price' => 200,
                'opening_hours' => '9:00 صباحاً - 4:00 مساءً',
                'rating' => 4.5,
                'reviews_count' => 80,
                'highlights' => ['أحجار الزمرد', 'خريطة مناجم الذهب', 'أدوات التعدين القديمة'],
            ],

            // Marsa Matrouh (مرسى مطروح)
            [
                'name' => 'متحف روميل',
                'location' => 'Marsa Matrouh',
                'address' => 'جزيرة روميل، مرسى مطروح',
                'description' => 'كهف كان يستخدمه القائد الألماني إرفين روميل كمقر للقيادة خلال الحرب العالمية الثانية.',
                'image' => '/images/museums/rommel-museum.jpg',
                'ticket_price' => 100,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.6,
                'reviews_count' => 600,
                'highlights' => ['أسلحة روميل', 'خرائط المعارك', 'الزي العسكري'],
            ],
            [
                'name' => 'متحف آثار مطروح',
                'location' => 'Marsa Matrouh',
                'address' => 'مكتبة مصر العامة، مرسى مطروح',
                'description' => 'متحف إقليمي يضم قطعاً أثرية من مختلف العصور المكتشفة في الصحراء الغربية.',
                'image' => '/images/museums/matrouh-museum.jpg',
                'ticket_price' => 150,
                'opening_hours' => '9:00 صباحاً - 5:00 مساءً',
                'rating' => 4.5,
                'reviews_count' => 200,
                'highlights' => ['آثار الصحراء الغربية', 'العصر الروماني', 'الأسلحة القديمة'],
            ],
            [
                'name' => 'متحف التراث السيوي',
                'location' => 'Marsa Matrouh',
                'address' => 'واحة سيوة، مطروح',
                'description' => 'متحف مبني بالطين (الكرشيف) يجسد التراث المعماري والثقافي لواحة سيوة.',
                'image' => '/images/museums/siwa-heritage.jpg',
                'ticket_price' => 50,
                'opening_hours' => '9:00 صباحاً - 8:00 مساءً',
                'rating' => 4.7,
                'reviews_count' => 400,
                'highlights' => ['الملابس السيوي', 'أدوات الزراعة', 'المجوهرات الفضية'],
            ],

            // Port Said (بورسعيد)
            [
                'name' => 'متحف بورسعيد القومي',
                'location' => 'Port Said',
                'address' => 'شارع فلسطين، بورسعيد',
                'description' => 'متحف يضم آثاراً من كل العصور المصرية، يقع عند التقاء قناة السويس بالبحر المتوسط.',
                'image' => '/images/museums/port-said-national.jpg',
                'ticket_price' => 150,
                'opening_hours' => '9:00 صباحاً - 4:00 مساءً',
                'rating' => 4.4,
                'reviews_count' => 300,
                'highlights' => ['المومياوات', 'العصر الإسلامي', 'الآثار اليونانية'],
            ],
            [
                'name' => 'متحف هيئة قناة السويس',
                'location' => 'Port Said',
                'address' => 'المبنى الإداري التاريخي، بورسعيد',
                'description' => 'يوثق تاريخ حفر قناة السويس والافتتاح الأسطوري لها عبر مقتنيات أصلية.',
                'image' => '/images/museums/suez-canal.jpg',
                'ticket_price' => 200,
                'opening_hours' => '9:00 صباحاً - 3:00 مساءً',
                'rating' => 4.8,
                'reviews_count' => 500,
                'highlights' => ['مقتنيات ديليسبس', 'ماكيتات القناة', 'سجلات الحفر'],
            ],
            [
                'name' => 'متحف النصر للفن الحديث',
                'location' => 'Port Said',
                'address' => 'ميدان الشهداء، بورسعيد',
                'description' => 'متحف فني يضم أعمالاً لكبار الفنانين التشكيليين المصريين.',
                'image' => '/images/museums/al-nasr-museum.jpg',
                'ticket_price' => 50,
                'opening_hours' => '10:00 صباحاً - 2:00 مساءً',
                'rating' => 4.5,
                'reviews_count' => 150,
                'highlights' => ['اللوحات التشكيلية', 'التماثيل البرونزية', 'الفنون المعاصرة'],
            ],

            // Fayoum (الفيوم)
            [
                'name' => 'متحف كوم أوشيم',
                'location' => 'Fayoum',
                'address' => 'مدينة كرانيس الأثرية، الفيوم',
                'description' => 'متحف محلي يعرض المكتشفات الأثرية من منطقة كرانيس وتاريخ محافظة الفيوم.',
                'image' => '/images/museums/kom-aushim.jpg',
                'ticket_price' => 100,
                'opening_hours' => '9:00 صباحاً - 4:00 مساءً',
                'rating' => 4.6,
                'reviews_count' => 250,
                'highlights' => ['بورتريهات الفيوم', 'البرديات اليونانية', 'العملات القديمة'],
            ],
            [
                'name' => 'متحف وادي الحيتان المفتوح',
                'location' => 'Fayoum',
                'address' => 'محمية وادي الريان، الفيوم',
                'description' => 'متحف مفتوح يضم حفريات لهياكل حيتان منقرضة منذ ملايين السنين.',
                'image' => '/images/museums/wadi-elhitan.jpg',
                'ticket_price' => 150,
                'opening_hours' => '8:00 صباحاً - 5:00 مساءً',
                'rating' => 4.9,
                'reviews_count' => 1200,
                'highlights' => ['هياكل الحيتان', 'عروس البحر المنقرضة', 'غابة الأشجار المتحجرة'],
            ],
            [
                'name' => 'متحف الكاريكاتير',
                'location' => 'Fayoum',
                'address' => 'قرية تونس، الفيوم',
                'description' => 'أول متحف للكاريكاتير في الشرق الأوسط، يضم آلاف اللوحات لكبار رسامي الكاريكاتير.',
                'image' => '/images/museums/caricature-museum.jpg',
                'ticket_price' => 50,
                'opening_hours' => '10:00 صباحاً - 6:00 مساءً',
                'rating' => 4.8,
                'reviews_count' => 400,
                'highlights' => ['لوحات الرسامين الرواد', 'الأنشطة الثقافية', 'الورش الفنية'],
            ],
        ];

        foreach ($data as $item) {
            Museum::create($item);
        }
    }
}
