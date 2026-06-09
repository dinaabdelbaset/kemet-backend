<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HajjUmrahPackage;

class HajjUmrahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name_en' => 'Bronze Hajj Package (Economy)',
                'name_ar' => 'باقة الحج الاقتصادية (البرونزية)',
                'price' => 850.00,
                'hotel_makkah_en' => 'Dar Al-Eiman Al-Sud (3★)',
                'hotel_makkah_ar' => 'فندق دار الإيمان السد (3 نجوم)',
                'hotel_madinah_en' => 'Al-Madinah Harmony Hotel (4★)',
                'hotel_madinah_ar' => 'فندق هارموني المدينة (4 نجوم)',
                'duration_days' => 10,
                'description_en' => 'Affordable Umrah pilgrimage package designed for families and group travelers. Includes clean accommodation, Visa service, guided rituals support, and standard group transfers.',
                'description_ar' => 'رحلة عمرة اقتصادية وميسرة مصممة خصيصاً للعائلات والمجموعات. تشمل إقامة فندقية مريحة ونظيفة، استخراج التأشيرة، إرشاد كامل للمناسك، وانتقالات جماعية قياسية.',
                'image' => 'https://images.unsplash.com/photo-1591604021695-0c69b7c05981?auto=format&fit=crop&q=80&w=800',
                'features_en' => [
                    'Standard Bus Transportation (Makkah - Madinah - Jeddah)',
                    'Shared Quad Rooms close to shuttle services',
                    'Umrah Visa Processing & Medical Insurance included',
                    'Accompanied Religious Tour Guide for rituals'
                ],
                'features_ar' => [
                    'حافلات نقل قياسية مجهزة (مكة - المدينة - جدة)',
                    'غرف رباعية مشتركة قريبة من مسارات الباصات',
                    'شامل رسوم تأشيرة العمرة والتأمين الطبي',
                    'مرشد ديني مرافق طوال فترة الرحلة لتسهيل المناسك'
                ],
            ],
            [
                'name_en' => 'Silver Hajj (Premium)',
                'name_ar' => 'الباقة الفضية المتميزة (حج)',
                'price' => 1450.00,
                'hotel_makkah_en' => 'Swissôtel Makkah (5★)',
                'hotel_makkah_ar' => 'فندق سويس أوتيل مكة (5 نجوم)',
                'hotel_madinah_en' => 'Al-Majeedi Oberoi Hotel (5★)',
                'hotel_madinah_ar' => 'فندق المجيدي أوبيروي المدينة (5 نجوم)',
                'duration_days' => 14,
                'description_en' => 'Experience a comfortable premium pilgrimage featuring 5-star hotel accommodations steps away from the Holy Haram, high-speed Haramain Train transfers between holy cities, and daily open buffet breakfast.',
                'description_ar' => 'عش تجربة عمرة راقية ومريحة تشمل الإقامة في فنادق 5 نجوم على بعد خطوات من الحرمين الشريفين، والانتقال عبر قطار الحرمين السريع المريح، بالإضافة إلى وجبة إفطار يومية بوفيه مفتوح.',
                'image' => 'https://images.unsplash.com/photo-1564769625905-50e9ad6319af?auto=format&fit=crop&q=80&w=800',
                'features_en' => [
                    'Haramain High-Speed Train Transfer (Business Class)',
                    'Double / Twin Luxury Rooms with Haram side views',
                    'Daily Open Buffet Breakfast & Dinner',
                    'Guided Ziyarat Historical Tours in Makkah & Madinah'
                ],
                'features_ar' => [
                    'انتقالات عبر قطار الحرمين السريع (درجة الأعمال)',
                    'غرف ثنائية فاخرة مع إطلالات جانبية للحرم',
                    'وجبتي الإفطار والعشاء بوفيه مفتوح يومياً',
                    'جولات سياحية دينية لزيارة المزارات التاريخية بمكة والمدينة'
                ],
            ],
            [
                'name_en' => 'VIP Gold Hajj (Royal)',
                'name_ar' => 'الباقة الذهبية الملكية (حج VIP)',
                'price' => 3200.00,
                'hotel_makkah_en' => 'Fairmont Makkah Clock Royal Tower (5★)',
                'hotel_makkah_ar' => 'فندق فيرمونت برج الساعة مكة (5 نجوم)',
                'hotel_madinah_en' => 'The Oberoi Madinah (5★ Deluxe)',
                'hotel_madinah_ar' => 'فندق أوبيروي المدينة (5 نجوم ديلاكس)',
                'duration_days' => 15,
                'description_en' => 'An elite royal pilgrimage package offering breathtaking Kaaba-facing luxury suites, private VIP luxury car transfers, 24/7 dedicated personal guide, full board fine dining, and exclusive spiritual lounges.',
                'description_ar' => 'باقة ملكية فاخرة للنخبة تقدم إقامة في أجنحة فاخرة مطلة مباشرة على الكعبة المشرفة، انتقالات خاصة بسيارات VIP فارهة، مرافق شخصي على مدار الساعة، إقامة كاملة الوجبات (بوفيه مفتوح فاخر)، وصالونات روحانية خاصة.',
                'image' => 'https://images.unsplash.com/photo-1541432901042-2d8bd64b4a9b?auto=format&fit=crop&q=80&w=800',
                'features_en' => [
                    'Holy Kaaba Facing Luxury Presidential Suites',
                    'Private VIP GMC / Mercedes S-Class Chauffeur Transfers',
                    'Full Board (Breakfast, Lunch & Dinner Gourmet Buffets)',
                    '24/7 Dedicated Personal Guide & Priority Haram Services'
                ],
                'features_ar' => [
                    'أجنحة رئاسية فاخرة مطلة مباشرة على الكعبة المشرفة',
                    'انتقالات خاصة بسيارات VIP وسائق خاص (GMC أو مرسيدس)',
                    'إقامة كاملة تشمل الفطور والغداء والعشاء ببوفيهات مفتوحة فاخرة',
                    'مرشد ديني وشخصي مرافق 24/7 مع خدمات أولوية للدخول للحرم'
                ],
            ]
        ];

        $makkahHotel = \App\Models\Hotel::where('location', 'like', '%Makkah%')
            ->orWhere('location', 'like', '%مكة%')
            ->orWhere('address', 'like', '%Makkah%')
            ->orWhere('address', 'like', '%مكة%')
            ->first() ?: \App\Models\Hotel::first();

        $madinahHotel = \App\Models\Hotel::where('location', 'like', '%Madinah%')
            ->orWhere('location', 'like', '%المدينة%')
            ->orWhere('address', 'like', '%Madinah%')
            ->orWhere('address', 'like', '%المدينة%')
            ->first() ?: (\App\Models\Hotel::skip(1)->first() ?: \App\Models\Hotel::first());

        $flight = \App\Models\Flight::first();
        $transportation = \App\Models\Transportation::first();

        foreach ($packages as $pkg) {
            if ($makkahHotel) {
                $pkg['hotel_makkah_id'] = $makkahHotel->id;
            }
            if ($madinahHotel) {
                $pkg['hotel_madinah_id'] = $madinahHotel->id;
            }
            if ($flight) {
                $pkg['flight_id'] = $flight->id;
            }
            if ($transportation) {
                $pkg['transportation_id'] = $transportation->id;
            }
            HajjUmrahPackage::create($pkg);
        }
    }
}
