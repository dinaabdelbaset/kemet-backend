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
                'image' => '/events/real_aswan_stargazing.jpg',
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
                'image' => 'https://images.unsplash.com/photo-1509316785289-025f5b846b35?w=800&fit=crop',
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
                'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&fit=crop',
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
                'image' => '/events/ev_wadi_rayan_camping.jpg',
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
                'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=800&fit=crop',
                'rating' => 4.9,
                'includes' => ['انتقالات', 'دليل بدوي', 'رسوم الدخول', 'وجبة إفطار', 'مشروبات ساخنة'],
                'difficulty' => 'صعب',
            ],
        ];

        foreach ($data as $item) {
            Safari::create($item);
        }
    }
}
