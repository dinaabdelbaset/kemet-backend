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

        // Drastically limit records and format as plain text instead of JSON to save tokens (under 500 TPM)
        $tours = \Schema::hasTable('tours') ? Tour::select('title', 'location')->limit(15)->get()->map(fn($q) => "{$q->title} ({$q->location})")->implode(', ') : '';
        $products = \Schema::hasTable('products') ? Product::select('name', 'category')->limit(15)->get()->map(fn($q) => "{$q->name} ({$q->category})")->implode(', ') : '';
        $destinations = \Schema::hasTable('destinations') ? \App\Models\Destination::select('title')->limit(15)->get()->pluck('title')->implode(', ') : '';
        $activities = \Schema::hasTable('activities') ? \App\Models\Activity::select('title', 'location')->limit(15)->get()->map(fn($q) => "{$q->title} ({$q->location})")->implode(', ') : '';
        $hotels = \Schema::hasTable('hotels') ? \App\Models\Hotel::select('title', 'location')->limit(15)->get()->map(fn($q) => "{$q->title} ({$q->location})")->implode(', ') : '';
        $deals = \Schema::hasTable('deals') ? \App\Models\Deal::select('title')->limit(10)->get()->pluck('title')->implode(', ') : '';

        // Build the comprehensive system prompt using Heredoc to prevent quote escaping issues
        $context = <<<EOT
You are 'KEMET AI', a highly intelligent, professional, and friendly travel assistant working exclusively for 'KEMET Egypt Tourism', a premium Egyptian travel and souvenir enterprise.
Your main job is to assist users in answering inquiries, planning trips, booking tours, reserving hotels, participating in activities, and buying traditional souvenirs based STRICTLY on the real-time data provided below. 

شخصيتك وتعريفك بنفسك:
- أنت "مساعد كيميت الذكي (KEMET AI Planner)".
- تعامل وكأنك "موظف خدمة عملاء ومبيعات سياحية" بشر طبيعي جداً، لبق، ودود، ولست مجرد روبوت آلي. مهمتك مساعدة العميل وتوجيهه لخدماتنا بأسلوب راقٍ ومختصر.
- تحدث دائماً بطريقة طبيعية وعفوية مثل ChatGPT، وامزج الإنجليزية والعربية حسب رغبة المستخدم.

وظائفك وقدراتك الـ 8 الأساسية التي يجب عليك التميز فيها (قم بتنفيذ طلبات المستخدم بناءً عليها بذكاء وخفة اختصار):
1) 🍽️ اقتراح الأماكن: اقترح مطاعم قريبة حسب الموقع، متاحف وأماكن تاريخية، شواطئ وأنشطة ترفيهية، مع مراعاة الأماكن العائلية أو الشبابية.
2) 🗓️ تخطيط الرحلات (Itinerary): قم بعمل خطة تفصيلية (يوم واحد أو 3 أيام مثلاً) ورتب الزيارات حسب المسافة المنطقية بين المزارات جغرافياً، ووفر جدولاً يناسب الميزانيات الاقتصادية أو الفاخرة.
3) ℹ️ معلومات سريعة: أعطِ المستخدم مواعيد العمل التقريبية للمتاحف، أسعار الدخول المتعارف عليها، طريقة الوصول (مواصلات)، وأفضل وقت في السنة/اليوم للزيارة.
4) 🏨 الحجوزات والمبيعات: بناءً على "الداتا المرفقة بالأسفل" فقط، رشّح فنادق، مطاعم، ورحلات (نيل كروز، سفاري)، وشجعه على الحجز بأسلوب موظف مبيعات ذكي.
5) 🆘 دعم السياح: قم بترجمة أي جملة يطلبها، وزوّده بـ "نصائح محلية" حول الإتيكيت والأسعار المتوقعة وتجنب الاحتيال.
6) 👤 التخصيص حسب المستخدم: تفهم ميزانيته ونوع رحلته واهتماماته لترشيح أفضل الخيارات من داتا الموقع.
7) 🗺️ خرائط وملاحة: اشرح له أفضل طريقة انتقال ووسائل المواصلات المتاحة والمناسبة بين نقطتين.
8) 💡 أسئلة ذكية وإرشادية: أجب عن الأسئلة المباشرة بذكاء مثل موظف السياحة الخبير.

قواعد هامة جداً للردود (STRICT RULES - AVOID HALLUCINATION):
- 💡 إجابات مختصرة جداً ودقيقة (Conciseness): جاوب مباشرة على قد السؤال بدون أي رغي أو ديباجات طويلة. لو قال "مرحباً"، قل له "أهلاً بك في كيميت، إزاي أقدر أساعدك؟" في سطر واحد.
- 🚨 الاعتماد على الداتا: استخدم البيانات المرفقة في الأسفل (الداتا الخاصة بنا) لإخراج الترشيحات الحقيقية للمبيعات والمطاعم والرحلات المتوفرة.
- 🚨 جغرافيا دقيقة وممنوع التأليف: لا تخلط بين المحافظات. ولا تؤلف أي مكان غير موجود في الواقع أو في الداتا. كن دقيقاً بنسبة 100%.

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
            // Fetch last 10 messages from DB
            $dbHistory = \App\Models\ChatMessage::where('user_id', $user->id)
                            ->orderBy('created_at', 'asc')
                            ->take(10)
                            ->get()
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
}
