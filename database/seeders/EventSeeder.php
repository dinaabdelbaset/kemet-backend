<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('events')->truncate();

        $events = [
            // ── Cairo (8 events) ────────────────────────────────────────────
            ['title'=>'معرض القاهرة الدولي للكتاب','location'=>'Cairo','category'=>'Cultural','image'=>'/events/ev_cairo_book_fair.jpg','date'=>'2025-01-23','price'=>'30.00','description'=>'أكبر معرض كتاب في الشرق الأوسط وأفريقيا، يضم آلاف دور النشر من 50 دولة في مركز القاهرة للمعارض الدولية.'],
            ['title'=>'مهرجان القاهرة السينمائي الدولي','location'=>'Cairo','category'=>'Art','image'=>'/events/ev_cairo_film_fest.jpg','date'=>'2025-11-13','price'=>'150.00','description'=>'أعرق مهرجان سينمائي في أفريقيا والشرق الأوسط، يُقام منذ 1976 ويستضيف نخبة من صناع السينما العالمية.'],
            ['title'=>'عروض الدراويش المولوية','location'=>'Cairo','category'=>'Cultural','image'=>'/events/ev_whirling_dervishes.jpg','date'=>'2025-12-01','price'=>'80.00','description'=>'عروض الدراويش الصوفية المبهرة في وكالة الغوري الأثرية — تجربة روحية أصيلة في قلب القاهرة التاريخية.'],
            ['title'=>'ليالي أوبرا القاهرة — عايدة','location'=>'Cairo','category'=>'Art','image'=>'/events/event_opera_aida.png','date'=>'2025-03-15','price'=>'200.00','description'=>'عرض أوبرا فيردي "عايدة" الأيقوني على مسرح دار الأوبرا المصرية الكبير بأزياء فرعونية فاخرة.'],
            ['title'=>'حفلة جاز النيل بقارب','location'=>'Cairo','category'=>'Music','image'=>'/events/event_cairo_jazz.png','date'=>'2025-06-20','price'=>'120.00','description'=>'حفل موسيقى جاز على متن عبارة نيلية تبحر بين كوبري قصر النيل وكوبري 6 أكتوبر مع مناظر المدينة الرائعة.'],
            ['title'=>'مهرجان القلعة للموسيقى والغناء','location'=>'Cairo','category'=>'Music','image'=>'/events/event_hero_banner.png','date'=>'2025-07-10','price'=>'100.00','description'=>'مهرجان موسيقي صيفي سنوي يُقام بالقلعة تحت النجوم، يجمع كبار الفنانين العرب في أجواء تاريخية فريدة.'],
            ['title'=>'عرض الصوت والضوء بالأهرامات','location'=>'Giza','category'=>'Show','image'=>'/events/ev_pyramids_sound_light.jpg','date'=>'2025-05-01','price'=>'250.00','description'=>'أشهر عرض في العالم: أضواء ليزر مبهرة وحكايات فرعونية مسموعة تُضيء أهرامات الجيزة والأبو الهول ليلاً.'],
            ['title'=>'سباق الخيول الدولي بمضمار الجيزة','location'=>'Giza','category'=>'Sport','image'=>'/events/event_red_sea_edm.png','date'=>'2025-04-05','price'=>'50.00','description'=>'سباق الخيول الأرستقراطي السنوي بمضمار سباق الخيول في الجيزة، يستقطب الخيول الأصيلة من دول عربية وأوروبية.'],

            // ── Alexandria (6 events) ────────────────────────────────────────
            ['title'=>'مهرجان الإسكندرية السينمائي لدول البحر المتوسط','location'=>'Alexandria','category'=>'Art','image'=>'/events/ev_alex_film_fest.jpg','date'=>'2025-09-20','price'=>'100.00','description'=>'المهرجان الوحيد في مصر المتخصص في سينما دول البحر المتوسط، يعرض أفلاماً نادرة على كورنيش الإسكندرية.'],
            ['title'=>'حفلات مسرح سيد درويش','location'=>'Alexandria','category'=>'Art','image'=>'/events/ev_alex_opera.jpg','date'=>'2025-10-12','price'=>'120.00','description'=>'عروض مسرحية وغنائية كلاسيكية في المسرح التاريخي الأنيق الذي سُمي تيمناً بالموسيقار العظيم سيد درويش.'],
            ['title'=>'مهرجان الإسكندرية الدولي للأغنية','location'=>'Alexandria','category'=>'Music','image'=>'/events/alex_event_1.png','date'=>'2025-08-15','price'=>'90.00','description'=>'مهرجان غنائي دولي يجمع أصوات عربية وعالمية على مسرح أمام البحر المتوسط في أجواء صيفية رائعة.'],
            ['title'=>'معرض الفنون التشكيلية الإسكندرانية','location'=>'Alexandria','category'=>'Cultural','image'=>'/events/alex_event_2.png','date'=>'2025-11-01','price'=>'40.00','description'=>'معرض سنوي لأعمال الفنانين الإسكندرانيين في قصر الفنون بالمنتزه، يضم لوحات وأعمال نحتية وفوتوغرافية.'],
            ['title'=>'ماراثون الإسكندرية الدولي','location'=>'Alexandria','category'=>'Sport','image'=>'/events/event_pyramids_light_show.png','date'=>'2025-12-10','price'=>'80.00','description'=>'ماراثون دولي على كورنيش الإسكندرية، مسار 42 كم بمنظر البحر المتوسط، يستقطب آلاف العدائين من العالم.'],
            ['title'=>'مهرجان الإسكندرية للمسرح','location'=>'Alexandria','category'=>'Art','image'=>'/events/concert_stage.png','date'=>'2025-07-05','price'=>'70.00','description'=>'عروض مسرحية عربية وعالمية على مسارح الإسكندرية الشهيرة، يتميز بورش عمل وندوات مع كبار المخرجين.'],

            // ── Luxor (6 events) ─────────────────────────────────────────────
            ['title'=>'عرض الصوت والضوء بالكرنك','location'=>'Luxor','category'=>'Show','image'=>'/events/ev_karnak_sound_light.jpg','date'=>'2025-04-15','price'=>'200.00','description'=>'رحلة عبر الزمن داخل معبد الكرنك العملاق: أعمدة عملاقة تضيء بأشعة الليزر وصوت يحكي قصص الفراعنة العظماء.'],
            ['title'=>'مهرجان الأقصر للسينما الأفريقية','location'=>'Luxor','category'=>'Art','image'=>'/events/ev_luxor_african_film.jpg','date'=>'2025-03-06','price'=>'120.00','description'=>'المهرجان الأبرز لسينما أفريقيا، يُقام أمام المعابد الفرعونية ويستقطب مخرجين وممثلين من كل القارة الأفريقية.'],
            ['title'=>'عيد الأوبت — ابتهالات معبد الأقصر','location'=>'Luxor','category'=>'Historical','image'=>'/events/luxor_film_1.png','date'=>'2025-02-20','price'=>'150.00','description'=>'إحياء لمهرجان الأوبت الفرعوني العريق بمسيرات تاريخية من الكرنك إلى معبد الأقصر على ضفاف النيل.'],
            ['title'=>'سباق مراكب النيل التقليدية','location'=>'Luxor','category'=>'Sport','image'=>'/events/luxor_film_2.png','date'=>'2025-05-20','price'=>'60.00','description'=>'سباق المراكب الشراعية الخشبية التقليدية على النيل أمام معابد الأقصر — منافسة تجمع الصيادين المحليين والسياح.'],
            ['title'=>'حفل توزيع جوائز مهرجان الأقصر','location'=>'Luxor','category'=>'Art','image'=>'/events/luxor_film_3.png','date'=>'2025-03-10','price'=>'180.00','description'=>'حفل ختام مهرجان الأقصر للسينما الأفريقية بحضور نجوم السينما ومنح جوائز للأفضل في الإنتاج الأفريقي.'],
            ['title'=>'مهرجان الفنون بطيبة — وادي الملوك','location'=>'Luxor','category'=>'Cultural','image'=>'/events/luxor_film_4.png','date'=>'2025-06-01','price'=>'90.00','description'=>'مهرجان فنون أثري يُقام قرب وادي الملوك يضم عروض موسيقى نوبية وعروض ضوء تبرز جمال المنطقة.'],

            // ── Aswan (6 events) ─────────────────────────────────────────────
            ['title'=>'مهرجان تعامد الشمس على وجه رمسيس','location'=>'Aswan','category'=>'Historical','image'=>'/events/ev_abu_simbel_sun.jpg','date'=>'2025-02-22','price'=>'300.00','description'=>'ظاهرة فلكية فريدة تحدث مرتين سنوياً داخل معبد أبو سمبل — يخترق شعاع الشمس 65 متراً ليُضيء وجه رمسيس.'],
            ['title'=>'مهرجان النوبة للموسيقى والثقافة','location'=>'Aswan','category'=>'Music','image'=>'/events/ev_aswan_nubia_music.jpg','date'=>'2025-11-10','price'=>'80.00','description'=>'مهرجان أسواني أصيل يحتفي بثقافة النوبة بموسيقى ورقصات تقليدية على ضفاف النيل بين الجرانيت والنخيل.'],
            ['title'=>'عرض الصوت والضوء بفيلة','location'=>'Aswan','category'=>'Show','image'=>'/events/abu_simbel_festival.png','date'=>'2025-04-20','price'=>'180.00','description'=>'عرض ضوء وصوت مميز في جزيرة فيلة العائمة على بحيرة ناصر — معبد إيزيس يتحول لمسرح أسطوري ليلياً.'],
            ['title'=>'ليالي الكوكب — سماء أسوان النجومية','location'=>'Aswan','category'=>'Cultural','image'=>'/events/abu_simbel_gallery_1.png','date'=>'2025-01-15','price'=>'120.00','description'=>'جلسات فلكية ليلية في الصحراء النوبية حيث السماء الأنقى في مصر، يقودها خبراء فلك مع تلسكوبات متطورة.'],
            ['title'=>'سباق الفلوكة على النيل بأسوان','location'=>'Aswan','category'=>'Sport','image'=>'/events/abu_simbel_gallery_2.png','date'=>'2025-10-05','price'=>'50.00','description'=>'منافسة سنوية لقوارب الفلوكة النيلية التقليدية بين جزر الحجر والنيل، مشاركة سياحية ومحلية حقيقية.'],
            ['title'=>'مهرجان القرية النوبية الثقافي','location'=>'Aswan','category'=>'Cultural','image'=>'/events/abu_simbel_gallery_3.png','date'=>'2025-12-20','price'=>'60.00','description'=>'احتفالية بثقافة القرية النوبية بمأكولاتها وموسيقاها وحرفها اليدوية — تجربة غمر كاملة في التراث النوبي الأصيل.'],

            // ── Sharm El-Sheikh (6 events) ───────────────────────────────────
            ['title'=>'مهرجان شرم الشيخ الدولي للمسرح الإبداعي','location'=>'Sharm El-Sheikh','category'=>'Art','image'=>'/events/ev_sharm_theater.jpg','date'=>'2025-10-25','price'=>'150.00','description'=>'مهرجان مسرحي دولي يستضيف فرقاً من أوروبا وآسيا وأفريقيا على خشبات شرم الشيخ بفيو البحر الأحمر.'],
            ['title'=>'حفلات سوهو سكوير الصيفية','location'=>'Sharm El-Sheikh','category'=>'Music','image'=>'/events/ev_sharm_soho_concert.jpg','date'=>'2025-08-01','price'=>'100.00','description'=>'سلسلة حفلات موسيقية صيفية في مجمع سوهو سكوير المفتوح — موسيقى حية بأنواع مختلفة كل ليلة.'],
            ['title'=>'بطولة الغوص الدولية بالبحر الأحمر','location'=>'Sharm El-Sheikh','category'=>'Sport','image'=>'/events/sharm_concert_1.png','date'=>'2025-11-15','price'=>'200.00','description'=>'أكبر بطولة غوص في الشرق الأوسط بمشاركة 300 غواص من 40 دولة في شعاب مرجانية رأس محمد الأسطورية.'],
            ['title'=>'مؤتمر شرم الشيخ للسياحة المستدامة','location'=>'Sharm El-Sheikh','category'=>'Cultural','image'=>'/events/sharm_concert_2.png','date'=>'2025-09-01','price'=>'350.00','description'=>'مؤتمر دولي يجمع خبراء البيئة والسياحة لمناقشة حماية الشعاب المرجانية ومستقبل السياحة البيئية.'],
            ['title'=>'مهرجان الموسيقى الإلكترونية بشرم','location'=>'Sharm El-Sheikh','category'=>'Music','image'=>'/events/sharm_theater_1.png','date'=>'2025-12-31','price'=>'250.00','description'=>'حفل رأس السنة الإلكتروني الأشهر في مصر — DJ عالميون يُقدمون عروضاً حتى الفجر على شاطئ خليج نعمة.'],
            ['title'=>'أسبوع التصوير الضوئي تحت الماء','location'=>'Sharm El-Sheikh','category'=>'Cultural','image'=>'/events/sharm_theater_2.png','date'=>'2025-05-10','price'=>'180.00','description'=>'فعالية سنوية لعشاق التصوير تحت الماء مع ورش عمل وجولات غوص مصحوبة بمصورين محترفين في البحر الأحمر.'],

            // ── Hurghada / El Gouna (6 events) ──────────────────────────────
            ['title'=>'مهرجان الجونة السينمائي الدولي (GFF)','location'=>'Hurghada','category'=>'Art','image'=>'/events/ev_gouna_film_fest.jpg','date'=>'2025-10-10','price'=>'200.00','description'=>'مهرجان سينمائي دولي راقٍ بالجونة، يستضيف نجوم السينما العالمية بجانب قنوات المياه وأضواء النيل الوهاجة.'],
            ['title'=>'بطولة الجونة الدولية للإسكواش','location'=>'Hurghada','category'=>'Sport','image'=>'/events/film_celeb_1.png','date'=>'2025-10-20','price'=>'100.00','description'=>'بطولة البلاتينيوم في الإسكواش تجمع أفضل لاعبي العالم في ملعب زجاجي شهير بالجونة — حدث رياضي عالمي الصدى.'],
            ['title'=>'كرنفال البحر الأحمر الصيفي','location'=>'Hurghada','category'=>'Music','image'=>'/events/film_celeb_2.png','date'=>'2025-07-25','price'=>'80.00','description'=>'كرنفال ليلي صاخب على كورنيش الغردقة بعروض موسيقية وألعاب نارية وزوارق مضيئة على البحر الأحمر.'],
            ['title'=>'رحلة مشاهدة الدلافين والغروب','location'=>'Hurghada','category'=>'Sport','image'=>'/events/film_celeb_3.png','date'=>'2025-06-15','price'=>'150.00','description'=>'رحلة بحرية يومية لمشاهدة دلافين البحر الأحمر في بيئتها الطبيعية ثم حفل غروب على الشاطئ.'],
            ['title'=>'مهرجان الجونة الدولي للريح والكايت','location'=>'Hurghada','category'=>'Sport','image'=>'/events/concert_fireworks.png','date'=>'2025-11-05','price'=>'60.00','description'=>'بطولة الرياضات الهوائية في الجونة — كايت سيرفينج ووندسيرفينج بمشاركة بطولية دولية على بحيرة الجونة.'],
            ['title'=>'سوق الجونة الليلي الثقافي','location'=>'Hurghada','category'=>'Cultural','image'=>'/events/event_hero_banner.png','date'=>'2025-08-20','price'=>'0.00','description'=>'سوق ليلي أسبوعي في الجونة يجمع الحرف اليدوية والفنون والمأكولات المصرية الأصيلة في أجواء ترفيهية مميزة.'],

            // ── Fayoum (6 events) ────────────────────────────────────────────
            ['title'=>'مهرجان الفخار والحرف بقرية تونس','location'=>'Fayoum','category'=>'Cultural','image'=>'/events/ev_fayoum_pottery.jpg','date'=>'2025-03-21','price'=>'40.00','description'=>'احتفالية الحرف اليدوية في قرية تونس السياحية — فخار وسجاد ونسيج يدوي يصنعه أمهر الحرفيين المصريين.'],
            ['title'=>'مهرجان الفيوم للفنون البصرية','location'=>'Fayoum','category'=>'Art','image'=>'/events/event_whirling_dervishes.png','date'=>'2025-04-10','price'=>'50.00','description'=>'معرض فنون مفتوح في طبيعة الفيوم يضم فناني التصوير والرسم والنحت مع ورش عمل ليلية بمنظر بحيرة قارون.'],
            ['title'=>'رحلة الطيور المهاجرة ببحيرة قارون','location'=>'Fayoum','category'=>'Cultural','image'=>'/events/event_book_fair.png','date'=>'2025-02-01','price'=>'60.00','description'=>'جولة إيكولوجية موسمية لمراقبة مئات الآلاف من الطيور المهاجرة على بحيرة قارون مع خبراء الطيور.'],
            ['title'=>'مهرجان الصيد التقليدي بالفيوم','location'=>'Fayoum','category'=>'Cultural','image'=>'/events/event_cairo_jazz.png','date'=>'2025-10-01','price'=>'30.00','description'=>'مهرجان الصيد الشعبي السنوي على بحيرة قارون — مراكب الصيادين تتراص والعائلات تستمتع بأسماك مشوية طازجة.'],
            ['title'=>'ليالي التخييم الصحراوية بوادي الريان','location'=>'Fayoum','category'=>'Sport','image'=>'/events/event_pyramids_light_show.png','date'=>'2025-01-10','price'=>'200.00','description'=>'رحلة تخييم شاملة في محمية وادي الريان بجانب الشلالات — أنشطة طبيعية وجلسات نار ومشاهدة النجوم.'],
            ['title'=>'ماراثون الصحراء الفيومية','location'=>'Fayoum','category'=>'Sport','image'=>'/events/event_red_sea_edm.png','date'=>'2025-12-15','price'=>'150.00','description'=>'ماراثون عبر تضاريس الفيوم المتنوعة — صحراء وأودية وبحيرات — تجربة فريدة لعشاق الرياضة في الطبيعة.'],
        ];

        foreach ($events as $e) {
            DB::table('events')->insert([
                'title'       => $e['title'],
                'location'    => $e['location'],
                'category'    => $e['category'],
                'image'       => $e['image'],
                'date'        => $e['date'],
                'price'       => $e['price'],
                'description' => $e['description'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
