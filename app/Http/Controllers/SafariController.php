<?php

namespace App\Http\Controllers;

use App\Models\Safari;
use Illuminate\Http\Request;

class SafariController extends Controller
{
    public function index()
    {
        if (Safari::count() === 0) {
            $this->seedSafaris();
        }

        return response()->json(Safari::all());
    }

    public function show($id)
    {
        $safari = Safari::find($id);
        if (!$safari) {
            return response()->json(['message' => 'Safari not found'], 404);
        }
        return response()->json($safari);
    }

    private function seedSafaris()
    {
        $data = [
            [
                'title' => 'سفاري وتخييم الصحراء البيضاء',
                'description' => 'تجربة لا تُنسى في الصحراء البيضاء والسوداء. تخييم تحت النجوم وسط التكوينات الطباشيرية، وزيارة جبل الكريستال مع عشاء بدوي أصيل.',
                'location' => 'واحة الفرافرة، الصحراء الغربية',
                'duration' => 'يومين / ليلة واحدة',
                'price' => 120,
                'image' => '/images/safaris2/white_desert.png',
                'rating' => 4.9,
                'includes' => ['سيارات دفع رباعي', 'معدات تخييم', 'وجبات كاملة', 'مرشد سياحي', 'زيارة جبل الكريستال'],
                'difficulty' => 'سهل',
            ],
            [
                'title' => 'مغامرة واحة سيوة وبحيرات الملح',
                'description' => 'استكشف واحة سيوة الساحرة، اسبح في عيون المياه الكبريتية وبحيرات الملح الصافية، واستمتع بتجربة التزلج على الرمال الناعمة في بحر الرمال الأعظم.',
                'location' => 'واحة سيوة',
                'duration' => '3 أيام / ليلتين',
                'price' => 250,
                'image' => '/images/safaris2/siwa_oasis.png',
                'rating' => 4.8,
                'includes' => ['إقامة فندقية', 'وجبات', 'تزلج على الرمال', 'زيارة عيون المياه', 'سيارات 4x4'],
                'difficulty' => 'متوسط',
            ],
            [
                'title' => 'سفاري البيتش باجي في الغردقة',
                'description' => 'انطلق في رحلة مثيرة بالبيتش باجي (ATV) في صحراء الغردقة وقت الغروب. استمتع بزيارة قرية بدوية، ركوب الجمال، وتناول عشاء شواء تقليدي.',
                'location' => 'الغردقة، البحر الأحمر',
                'duration' => '5 ساعات',
                'price' => 45,
                'image' => '/images/safaris2/hurghada_atv.png',
                'rating' => 4.7,
                'includes' => ['ركوب بيتش باجي', 'زيارة قرية بدوية', 'ركوب جمال', 'عشاء شواء', 'شاي بدوي'],
                'difficulty' => 'سهل',
            ],
            [
                'title' => 'رحلة وادي الريان ووادي الحيتان',
                'description' => 'استكشف شلالات وادي الريان ومحمية وادي الحيتان (موقع تراث عالمي). مغامرة تجمع بين التاريخ الطبيعي والتزلج على الرمال والتخييم الصحراوي.',
                'location' => 'الفيوم',
                'duration' => 'يوم كامل',
                'price' => 65,
                'image' => '/images/safaris2/wadi_rayan.png',
                'rating' => 4.6,
                'includes' => ['انتقالات', 'تذاكر المحميات', 'مرشد سياحي', 'غداء بدوي', 'تزلج على الرمال'],
                'difficulty' => 'سهل',
            ],
            [
                'title' => 'سفاري جبال سيناء ودير سانت كاترين',
                'description' => 'مغامرة تسلق جبل موسى فجراً لمشاهدة شروق الشمس الساحر، تليها زيارة لدير سانت كاترين التاريخي وأشجار الزيتون القديمة.',
                'location' => 'سانت كاترين، جنوب سيناء',
                'duration' => 'يوم كامل',
                'price' => 85,
                'image' => '/images/safaris/bahariya-oasis.jpg',
                'rating' => 4.9,
                'includes' => ['انتقالات', 'دليل بدوي', 'رسوم الدخول', 'وجبة إفطار', 'مشروبات ساخنة'],
                'difficulty' => 'صعب',
            ],
            [
                'title' => 'هايكنج محمية وادي دجلة والتخييم',
                'description' => 'هروب سريع من صخب القاهرة إلى محمية وادي دجلة بالمعادي. استمتع برياضة المشي (الهايكنج) وسط الأخاديد الجيرية، وركوب الدراجات الجبلية، وعشاء شواء في الطبيعة.',
                'location' => 'المعادي، القاهرة',
                'duration' => 'نصف يوم',
                'price' => 35,
                'image' => '/images/destinations/cairo/cycling.png',
                'rating' => 4.5,
                'includes' => ['تذاكر دخول', 'مرشد هايكنج', 'دراجات جبلية', 'عشاء شواء', 'مشروبات'],
                'difficulty' => 'متوسط',
            ],
            [
                'title' => 'سفاري الوادي الملون (الكانيون)',
                'description' => 'اكتشف سحر الطبيعة في الكانيون الملون بطابا. مشي بين صخور رملية بألوان مذهلة تشكلت عبر ملايين السنين، تجربة بصرية تخطف الأنفاس.',
                'location' => 'نويبع / طابا، سيناء',
                'duration' => 'يوم كامل',
                'price' => 55,
                'image' => '/images/safaris2/bahariya_oasis.png',
                'rating' => 4.8,
                'includes' => ['سيارات دفع رباعي', 'مرشد بدوي', 'رسوم المحمية', 'غداء', 'مياه ومشروبات'],
                'difficulty' => 'متوسط',
            ],
            [
                'title' => 'سفاري الجمال في القرى النوبية',
                'description' => 'رحلة ساحرة على ظهور الجمال عبر رمال أسوان الذهبية وعلى ضفاف النيل حتى القرى النوبية الملونة ودير الأنبا سمعان.',
                'location' => 'أسوان',
                'duration' => '3 ساعات',
                'price' => 30,
                'image' => '/images/destinations/aswan/camel.png',
                'rating' => 4.7,
                'includes' => ['ركوب الجمال', 'مرشد نوبي', 'زيارة قرية نوبية', 'شاي نوبي', 'استراحة'],
                'difficulty' => 'سهل',
            ],
            [
                'title' => 'استكشاف محمية وادي الجمال',
                'description' => 'رحلة سفاري في "مالديف مصر" لاستكشاف الحياة البرية في محمية وادي الجمال، حيث تلتقي الصحراء بالبحر الأحمر والغزلان البرية.',
                'location' => 'مرسى علم، البحر الأحمر',
                'duration' => 'يوم كامل',
                'price' => 75,
                'image' => '/images/destinations/hurghada/bedouin.png',
                'rating' => 4.9,
                'includes' => ['سيارات 4x4', 'تذاكر دخول المحمية', 'غداء بدوي', 'سنوركلينج', 'مرشد سياحي'],
                'difficulty' => 'سهل',
            ],
        ];

        foreach ($data as $item) {
            Safari::create($item);
        }
    }
}
