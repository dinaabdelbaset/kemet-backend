<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroqService;
use App\Models\Tour;
use App\Models\Product;

class ChatbotController extends Controller
{
    private GroqService $groqService;

    public function __construct(GroqService $groqService)
    {
        $this->groqService = $groqService;
    }

    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:15000'
        ]);

        $userMessage = $request->input('message');

        // Extract dataset fetching to helper to prevent IDE type overload
        $promptData = $this->getPromptData();
        extract($promptData);

        // Build the comprehensive system prompt using Heredoc to prevent quote escaping issues
        $context = <<<EOT
You are 'KEMET AI', a highly intelligent, professional, and friendly travel assistant working exclusively for 'KEMET Egypt Tourism', a premium Egyptian travel and souvenir enterprise.
Your main job is to assist users in answering inquiries, planning trips, booking tours, reserving hotels, participating in activities, and buying traditional souvenirs based STRICTLY on the real-time data provided below. 

شخصيتك وتعريفك بنفسك:
- أنت "مساعد كيميت الذكي (KEMET AI Planner)".
- تعامل وكأنك "موظف خدمة عملاء ومبيعات سياحية" بشر طبيعي جداً، لبق، ودود، ولست مجرد روبوت آلي. مهمتك مساعدة العميل وتوجيهه لخدماتنا بأسلوب راقٍ ومختصر.
- تحدث دائماً بطريقة طبيعية وعفوية مثل ChatGPT، وامزج الإنجليزية والعربية حسب رغبة المستخدم.

وظائفك وقدراتك الـ 7 الأساسية (نفذها باحترافية شديدة):
1) 🏖️ مساعدة العميل في الاختيار: ابدأ بطرح أسئلة تفاعلية ذكية (عايز بحر ولا آثار؟ ميزانيتك في حدود كام؟ مسافر إمتى؟) وبناءً على إجاباته رشح له مدن زي Sharm El-Sheikh أو Luxor.
2) 🔍 البحث السريع الدقيق: نفذ عمليات بحث من البيانات المرفقة مثل "فنادق في Hurghada تحت 2000 جنيه" أو "رحلات يوم واحد في Fayoum".
3) 🛒 الحجز الذكي (Booking Flow): قم بتجميع بيانات الحجز من العميل (تاريخ الرحلة - عدد الأشخاص - نوع الغرفة)، ثم وجهه فوراً للدفع وتأكيد الحجز عبر إعطائه رابط الحجز المباشر مثل: [إتمام الدفع والحجز](/checkout) أو رابط الفندق/الرحلة.
4) ℹ️ إجابات فورية: أجب عن حالة الطقس، أفضل وقت للزيارة، وأعطِ ترشيحات لأشهر الأماكن + البازارات + المطاعم (مثال: لو سأل "أروح فين في Aswan؟" رشح له من الداتا المرفقة).
5) 🗓️ بناء برامج كاملة (Itinerary): صمم جدول رحلة متكامل (يوم 1: وصول وفندق، يوم 2: أماكن سياحية ومتاحف، يوم 3: تسوق وبازارات).
6) 🆘 دعم ما بعد الحجز: طمئن العميل وأعطه تفاصيل رحلته، وإذا سأل "فين المندوب؟" أخبره أن المندوب سيتواصل معه قبل الرحلة بـ 24 ساعة، وإذا طلب تعديل الميعاد وجهه لصفحة [حجوزاتي](/bookings).
7) 💸 الـ Upselling (البيع الإضافي): بعد ترشيح فندق أو رحلة، اقترح دائماً أنشطة إضافية جذابة (سفاري، دايفنج، عشاء في نيل كروز) لزيادة المبيعات.

الخلاصة: أنت لست مجرد شات بوت، أنت = (موظف خدمة عملاء + سيلز مبيعات + مرشد سياحي خبير) في نفس الوقت!

قواعد هامة جداً للردود (STRICT RULES - AVOID HALLUCINATION):
- 🚨 الهوية (Platform Identity): **أنت تتحدث مع العميل من داخل الموقع.** لا تقل أبداً "يمكنك زيارة موقعنا" أو "اتصل بنا". أنت هو الموقع! إذا سأل "كيف أحجز؟"، أعطه فوراً روابط للأقسام لكي يضغط عليها ويحجز مثل: [حجز الفنادق](/hotels) أو [الرحلات](/tours) أو [السفاري](/safari).
- 💡 إجابات مختصرة ومقسمة: جاوب بشكل مباشر ومنظم (Bullet points). تجنب الإجابات الطويلة جداً في رسالة واحدة، بل اسأله "هل تحب أستكمل لك باقي الخطة؟".
- 🚨 الاعتماد على الداتا: استخدم البيانات المرفقة في الأسفل لإخراج الترشيحات. لا تخترع أسعاراً أو أماكن غير موجودة.
- 🚨 أزرار الحجز: استخدم Markdown للروابط كالتالي: [اسم المكان](/path). أمثلة:
   أ) فنادق: [فندق هلنان](/hotels/5) أو للمدينة [فنادق القاهرة](/hotels?city=Cairo)
   ب) رحلات: [رحلة الأهرامات](/tours/1)
   ج) متاحف: [المتحف المصري](/museums/2)
   د) سفاري: [سفاري سيناء](/safari/3)
   هـ) بازارات: [خان الخليلي](/bazaars/4)
   و) فعاليات: [مهرجان السينما](/events/5)
   ز) مواصلات: [حجز جو باص](/transportation/6)
   ح) مطاعم: [مطعم كشري التحرير](/restaurants/7)
   تنبيه: لا تظهر الـ ID كرقم صريح للعميل في النص، اكتب اسم المكان الحقيقي.
- 🚨 جغرافيا دقيقة: لا تخلط بين المحافظات. كن دقيقاً بنسبة 100%.
- 🌟 المعرفة بصفحات الموقع (Home Page Linking): 
   - أنت تعرف قسم "رحلة اليوم الواحد" (One Day Tour). وجه المستخدم لـ [/tours].
   - قسـم "مصر عبر الزمن" (Egypt through time). وجه المستخدم لـ [/museums] أو [/destinations].
   - عـروض "Grab up to 35% off on your favorite Destination" و "Today's Best Deals". وجه المستخدم لـ [/deals].
   - حـجز الطيران "احجز رحلتك الجوية إلى مصر" (Book Flights). وجه المستخدم لـ [/flights].
   - قسـم "التقييمات" (Customer Reviews). وجه العميل لها عبر [/reviews].
- 🚨 تسجيل التقييمات أوتوماتيكياً (Automated Reviews): 
   - إذا لاحظت أن العميل يقوم بكتابة تقييم (Review) صريح لرحلة أو فندق أو مطعم، اشكره أولاً، **ويجب** إضافة هذا الكود السري في آخر سطر من ردك تماماً:
     `[SAVE_REVIEW: item_type | item_id | rating | summary]`
   - أمثلة لـ item_type: `tour`, `hotel`, `restaurant`, `museum`.
   - أمثلة لـ rating: رقم من 1 إلى 5.
   - مثال حقيقي يجب أن تكتبه هكذا: `[SAVE_REVIEW: tour | 1 | 5 | رحلة رائعة جدا]`

--- KEMET FULL SERVICES & CAPABILITIES (Know everything the site offers) ---
نحن في موقع KEMET نوفر حجز كل شيء حرفياً من الألف للياء للسائح، وهي:
1. **الطيران:** طيران داخلي بين مدن مصر ودولي.
2. **المواصلات:** حجز سيارات، واصطحاب من المطار.
3. **الفنادق:** حجز فنادق ومنتجعات.
4. **الرحلات:** باقات سياحية جاهزة للأفراد والجروبات.
5. **الأنشطة الممتعة:** سفاري، غطس، رحلات يخوت.
6. **المطاعم:** أشهر المطاعم التراثية وعائمات النيل.
7. **المتاحف والفعاليات:** تذاكر وحضور الفعاليات.
8. **مرشد سياحي:** جاهز لأي رحلة.
9. **البازارات:** هدايا تراثية وفرعونية.

Primary Destinations We Cover: Cairo, Alexandria, Luxor, Aswan, Hurghada, Sharm El-Sheikh, Dahab, Marsa Alam, Siwa, Red Sea Coast.

--- OUR DESTINATIONS ---
{$destinations}

--- OUR HOTELS ---
{$hotels}

--- OUR RESTAURANTS ---
{$restaurants}

--- OUR MUSEUMS ---
{$museums}

--- OUR SAFARI ---
{$safaris}

--- OUR EVENTS ---
{$events}

--- OUR BAZAARS ---
{$bazaars}

--- OUR TRANSPORTATION ---
{$transportations}

--- OUR ACTIVITIES ---
{$activities}

--- OUR AVAILABLE TOURS & PACKAGES ---
{$tours}

--- EXCLUSIVE DEALS & OFFERS ---
{$deals}

--- OUR SOUVENIR SHOP DATA ---
{$products}

NOTE: Never tell the user you are an AI or an LLM. Always act as 'KEMET AI', an employee of the company.
EOT;

        $history = $request->input('history', []);

        // Retrieve real history from database if logged in
        $user = auth('sanctum')->user();
        if ($user) {
            // Fetch last 4 messages from DB to save tokens and prevent Groq 429 errors
            $dbHistory = \App\Models\ChatMessage::where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->take(4)
                            ->get()
                            ->reverse()
                            ->map(function ($msg) {
                                return [
                                    'role' => $msg->role,
                                    'content' => $msg->content
                                ];
                            })->toArray();
            
            // Merge frontend memory with DB memory intelligently or just use DB memory
            if (count($dbHistory) > 0) {
                $history = $dbHistory;
            }
        }

        // Call Groq
        $reply = $this->groqService->ask($userMessage, $context, $history);

        // Process AI saving review commands dynamically
        if (preg_match('/\[SAVE_REVIEW:\s*([^|\]]+?)\s*\|\s*([^|\]]+?)\s*\|\s*([^|\]]+?)\s*\|\s*([^\]]+?)\s*\]/ui', $reply, $matches)) {
            $itemType = strtolower(trim($matches[1]));
            $itemId = (int) trim($matches[2]);
            $rating = (int) trim($matches[3]);
            $comment = trim($matches[4]);

            if ($user && \Schema::hasTable('reviews')) {
                \DB::table('reviews')->insert([
                    'user_id' => $user->id,
                    'item_type' => $itemType, // Usually App\Models\Tour but keeping it simple for display
                    'item_id' => $itemId > 0 ? $itemId : 1, 
                    'rating' => $rating > 0 && $rating <= 5 ? $rating : 5,
                    'comment' => $comment,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            // Remove the secret code from the reply so the user doesn't see it (clean UI)
            $reply = trim(str_replace($matches[0], '', $reply));
        }

        // Save to Database
        if ($user) {
            \App\Models\ChatMessage::create([
                'user_id' => $user->id,
                'role' => 'user',
                'content' => $userMessage
            ]);
            \App\Models\ChatMessage::create([
                'user_id' => $user->id,
                'role' => 'assistant',
                'content' => $reply
            ]);
        }

        return response()->json([
            'answer' => $reply
        ]);
    }

    public function askAuth(Request $request)
    {
        return $this->ask($request);
    }

    public function history(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([]);
        }

        $messages = \App\Models\ChatMessage::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($msg) {
                return [
                    'sender' => $msg->role === 'assistant' ? 'bot' : 'user',
                    'text' => $msg->content
                ];
            });

        return response()->json($messages);
    }

    private function getPromptData(): array
    {
        return [
            'tours' => \Schema::hasTable('tours') ? Tour::select('id', 'title', 'location')->limit(5)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title} ({$q->location})")->implode(', ') : '',
            'products' => \Schema::hasTable('products') ? Product::select('id', 'name', 'category')->limit(5)->get()->map(fn($q) => "[ID:{$q->id}] {$q->name} ({$q->category})")->implode(', ') : '',
            'destinations' => \Schema::hasTable('destinations') ? \App\Models\Destination::select('id', 'title')->limit(5)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title}")->implode(', ') : '',
            'activities' => \Schema::hasTable('activities') ? \App\Models\Activity::select('id', 'title', 'location')->limit(5)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title} ({$q->location})")->implode(', ') : '',
            'restaurants' => \Schema::hasTable('restaurants') ? \DB::table('restaurants')->select('id', 'name', 'location')->limit(5)->get()->map(fn($q) => "[ID:{$q->id}] {$q->name} ({$q->location})")->implode(', ') : '',
            'museums' => \Schema::hasTable('museums') ? \DB::table('museums')->select('id', 'name', 'location')->limit(5)->get()->map(fn($q) => "[ID:{$q->id}] {$q->name} ({$q->location})")->implode(', ') : '',
            'safaris' => \Schema::hasTable('safaris') ? \DB::table('safaris')->select('id', 'title', 'location')->limit(5)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title} ({$q->location})")->implode(', ') : '',
            'events' => \Schema::hasTable('events') ? \DB::table('events')->select('id', 'title', 'location')->limit(5)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title} ({$q->location})")->implode(', ') : '',
            'bazaars' => \Schema::hasTable('bazaars') ? \DB::table('bazaars')->select('id', 'title', 'location')->limit(5)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title} ({$q->location})")->implode(', ') : '',
            'transportations' => \Schema::hasTable('transportations') ? \DB::table('transportations')->select('id', 'type', 'route')->limit(5)->get()->map(fn($q) => "[ID:{$q->id}] {$q->type} ({$q->route})")->implode(', ') : '',
            'hotels' => \Schema::hasTable('hotels') ? \App\Models\Hotel::select('id', 'title', 'location')->limit(5)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title} ({$q->location})")->implode(', ') : '',
            'deals' => \Schema::hasTable('deals') ? \App\Models\Deal::select('id', 'title')->limit(3)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title}")->implode(', ') : '',
        ];
    }

    public function getContext()
    {
        $data = $this->getDetailedContextData();

        // ===== أسعار الصرف الحية =====
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(5)
                ->get('https://api.exchangerate-api.com/v4/latest/EGP');
            if ($response->successful()) {
                $rates = $response->json('rates');
                $data['exchange_rates'] = "1 دولار أمريكي (USD) = " . round(1 / $rates['USD'], 2) . " ج.م\n"
                    . "1 يورو (EUR) = " . round(1 / $rates['EUR'], 2) . " ج.م\n"
                    . "1 جنيه إسترليني (GBP) = " . round(1 / $rates['GBP'], 2) . " ج.م\n"
                    . "1 ريال سعودي (SAR) = " . round(1 / $rates['SAR'], 2) . " ج.م\n"
                    . "1 درهم إماراتي (AED) = " . round(1 / $rates['AED'], 2) . " ج.م\n"
                    . "1 دينار كويتي (KWD) = " . round(1 / $rates['KWD'], 2) . " ج.م";
            }
        } catch (\Exception $e) {
            // Fallback - سعر تقريبي
            $data['exchange_rates'] = "1 دولار أمريكي (USD) ≈ 51 ج.م\n"
                . "1 يورو (EUR) ≈ 57 ج.م\n"
                . "1 جنيه إسترليني (GBP) ≈ 65 ج.م\n"
                . "1 ريال سعودي (SAR) ≈ 13.6 ج.م\n"
                . "1 درهم إماراتي (AED) ≈ 13.9 ج.م";
        }

        return response()->json($data);
    }

    private function getDetailedContextData(): array
    {
        return [
            'hotels' => $this->getDetailedHotelsContext(),
            'tours' => $this->getDetailedToursContext(),
            'restaurants' => $this->getDetailedRestaurantsContext(),
            'safaris' => $this->getDetailedSafarisContext(),
            'museums' => $this->getDetailedMuseumsContext(),
            'products' => $this->getDetailedProductsContext(),
            'deals' => $this->getDetailedDealsContext(),
            'destinations' => $this->getDetailedDestinationsContext(),
            'bazaars' => $this->getDetailedBazaarsContext(),
            'events' => $this->getDetailedEventsContext(),
            'transportation' => $this->getDetailedTransportationContext(),
        ];
    }

    private function getDetailedHotelsContext(): string {
        return \Schema::hasTable('hotels') ? \App\Models\Hotel::select('title', 'location', 'price_starts_from', 'rating')->orderBy('rating', 'desc')->limit(25)->get()->map(fn($h) => "{$h->title} - {$h->location} - من {$h->price_starts_from} ج.م/ليلة - تقييم {$h->rating}⭐")->implode("\n") : '';
    }

    private function getDetailedToursContext(): string {
        return \Schema::hasTable('tours') ? Tour::select('title', 'location', 'price', 'duration')->orderBy('price')->get()->map(fn($t) => "{$t->title} - {$t->location} - {$t->price} ج.م/شخص" . ($t->duration ? " - {$t->duration}" : ""))->implode("\n") : '';
    }

    private function getDetailedRestaurantsContext(): string {
        return \Schema::hasTable('restaurants') ? \App\Models\Restaurant::select('name', 'cuisine', 'location', 'price_range_min', 'price_range_max', 'rating')->orderBy('rating', 'desc')->limit(20)->get()->map(fn($r) => "{$r->name} - {$r->cuisine} - {$r->location} - {$r->price_range_min}-{$r->price_range_max} ج.م/شخص - {$r->rating}⭐")->implode("\n") : '';
    }

    private function getDetailedSafarisContext(): string {
        return \Schema::hasTable('safaris') ? \App\Models\Safari::select('title', 'location', 'price', 'duration', 'rating')->get()->map(fn($s) => "{$s->title} - {$s->location} - {$s->price} ج.م/شخص - {$s->duration} - {$s->rating}⭐")->implode("\n") : '';
    }

    private function getDetailedMuseumsContext(): string {
        return \Schema::hasTable('museums') ? \App\Models\Museum::select('name', 'location', 'ticket_price', 'rating')->get()->map(fn($m) => "{$m->name} - {$m->location} - تذكرة {$m->ticket_price} ج.م - {$m->rating}⭐")->implode("\n") : '';
    }

    private function getDetailedProductsContext(): string {
        return \Schema::hasTable('products') ? Product::select('name', 'category', 'price')->orderBy('category')->get()->map(fn($p) => "{$p->name} ({$p->category}) - {$p->price} ج.م")->implode("\n") : '';
    }

    private function getDetailedDealsContext(): string {
        return \Schema::hasTable('deals') ? \App\Models\Deal::select('title', 'category', 'price', 'locations')->limit(10)->get()->map(fn($d) => "{$d->title} ({$d->category}) - {$d->price} ج.م" . ($d->locations ? " - {$d->locations}" : ""))->implode("\n") : '';
    }

    private function getDetailedDestinationsContext(): string {
        return \Schema::hasTable('destinations') ? \App\Models\Destination::select('title', 'tours')->get()->map(fn($d) => "{$d->title} ({$d->tours} رحلة)")->implode(", ") : '';
    }

    private function getDetailedBazaarsContext(): string {
        if (!\Schema::hasTable('bazaars')) return '';
        return \App\Models\Bazaar::select('title', 'location', 'specialty')->get()->map(function($b) {
            $spec = is_array($b->specialty) ? implode(', ', $b->specialty) : $b->specialty;
            return "{$b->title} - {$b->location}" . ($spec ? " - تخصص: {$spec}" : "");
        })->implode("\n");
    }

    private function getDetailedEventsContext(): string {
        return \Schema::hasTable('events') ? \App\Models\Event::select('title', 'location', 'venue', 'date', 'price', 'category', 'rating')->get()->map(fn($e) => "{$e->title} ({$e->category}) - {$e->location}" . ($e->venue ? " - {$e->venue}" : "") . " - {$e->price} ج.م" . ($e->date ? " - {$e->date}" : "") . " - {$e->rating}⭐")->implode("\n") : '';
    }

    private function getDetailedTransportationContext(): string {
        return \Schema::hasTable('transportations') ? \App\Models\Transportation::select('type', 'route', 'company', 'class', 'price', 'duration', 'rating')->get()->map(fn($t) => "{$t->type}: {$t->route} - {$t->company} ({$t->class}) - {$t->price} ج.م - {$t->duration} - {$t->rating}⭐")->implode("\n") : '';
    }
}
