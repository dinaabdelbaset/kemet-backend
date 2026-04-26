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
            [
              'title' => 'خان الخليلي',
              'location' => 'القاهرة',
              'image' => '/images/bazaars/khan-el-khalili.jpg',
              'description' => 'أشهر وأقدم سوق تاريخي في قلب القاهرة الفاطمية. استمتع برائحة البخور والتوابل، وشاهد الحرفيين وهم يصنعون النحاسيات والمشغولات اليدوية والفوانيس أمام عينيك.',
              'specialty' => ['تحف ونحاسيات', 'مشغولات يدوية', 'فوانيس', 'فضيات'],
            ],
            [
              'title' => 'سوق التوابل النوبي',
              'location' => 'أسوان',
              'image' => '/images/bazaars/aswan-spice.jpg',
              'description' => 'انفجار حسي من الألوان والروائح في قلب أسوان. المكان الأفضل لشراء التوابل النوبية الأصلية، الكركديه الأسواني الفاخر، العطور الطبيعية، والبخور.',
              'specialty' => ['توابل وأعشاب', 'كركديه', 'عطور طبيعية', 'بخور'],
            ],
            [
              'title' => 'سوق الأقصر السياحي',
              'location' => 'الأقصر',
              'image' => '/images/bazaars/luxor-souq.jpg',
              'description' => 'تجول في أزقة السوق المليئة بتماثيل الألباستر المذهلة، ورق البردي، والملابس القطنية التقليدية بالقرب من معبد الأقصر العظيم.',
              'specialty' => ['ألباستر', 'ورق بردي', 'قطنيات', 'تماثيل فرعونية'],
            ],
            [
              'title' => 'السوق القديم (شرم الميه)',
              'location' => 'شرم الشيخ',
              'image' => '/images/bazaars/sharm-old-market.jpg',
              'description' => 'المنطقة الأكثر حيوية وأصالة في شرم الشيخ. يشتهر بمسجد الصحابة ذو المعمار المذهل، محلات الأعشاب التقليدية، الزيوت العطرية، والمقاهي المحلية.',
              'specialty' => ['زيوت عطرية', 'أعشاب سيناوية', 'هدايا تذكارية', 'مصنوعات جلدية'],
            ],
            [
              'title' => 'سوق المنشية',
              'location' => 'الإسكندرية',
              'image' => '/images/bazaars/mansheya-market.jpg',
              'description' => 'سوق محلي نابض بالحياة بالقرب من البحر المتوسط. يعكس الحياة اليومية السكندرية ويشتهر ببيع الأقمشة، المنتجات الطازجة، والقهوة العتيقة.',
              'specialty' => ['أقمشة', 'أطعمة شوارع', 'قهوة تركية', 'منتجات طازجة'],
            ],
            [
              'title' => 'سوق الدهار',
              'location' => 'الغردقة',
              'image' => '/images/bazaars/el-dahar-souq.jpg',
              'description' => 'أقدم أحياء الغردقة والسوق الشعبي الأهم. مكان رائع لتجربة الجانب غير السياحي للمدينة، وشراء الفواكه الاستوائية، والتوابل، والحرف اليدوية.',
              'specialty' => ['فواكه استوائية', 'توابل', 'حرف يدوية', 'مأكولات بحرية'],
            ],
            [
              'title' => 'ميدان أصالة',
              'location' => 'دهب',
              'image' => '/images/bazaars/assalah-square.jpg',
              'description' => 'المركز النابض لمدينة دهب، حيث تمتزج الثقافة البدوية مع الأجواء البوهيمية. ستجد المشغولات البدوية الملونة والملابس المريحة والمطاعم الشعبية.',
              'specialty' => ['مشغولات بدوية', 'ملابس بوهيمية', 'إكسسوارات خرز', 'أعشاب جبلية'],
            ],
            [
              'title' => 'سوق شالي',
              'location' => 'سيوة',
              'image' => '/images/bazaars/shali-market.jpg',
              'description' => 'سوق فريد يقع في واحة سيوة الساحرة. يشتهر ببيع أفضل أنواع التمور والزيتون، ومصابيح الملح الصخري التي تُنقي الهواء، والمنتجات اليدوية الأمازيغية.',
              'specialty' => ['تمور وزيتون', 'مصابيح ملح صخري', 'فخار سيوي', 'منسوجات أمازيغية'],
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
