<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroqService;
use App\Models\Tour;
use App\Models\Product;

class ChatbotController extends Controller
{
    private GroqService $aiService;

    public function __construct(GroqService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:15000',
            'session_token' => 'required|string|max:255'
        ]);

        $userMessage = $request->input('message');
        $sessionToken = $request->input('session_token');
        $user = auth('sanctum')->user();

        // Find or Create Chat Session
        $chatSession = \App\Models\ChatSession::firstOrCreate(
            ['session_token' => $sessionToken],
            ['user_id' => $user ? $user->id : null, 'is_human_mode' => false, 'is_closed' => false]
        );

        // Update user_id if logged in later
        if ($user && !$chatSession->user_id) {
            $chatSession->update(['user_id' => $user->id]);
        }

        // Save User Message only if it's not a timeout automated retry
        if (!$request->input('is_timeout')) {
            \App\Models\ChatMessage::create([
                'user_id' => $user ? $user->id : null,
                'session_id' => $sessionToken,
                'role' => 'user',
                'content' => $userMessage
            ]);
        }

        // If it is a new WebRTC offer, automatically upgrade the session to human mode so it appears in the admin panel session list
        if (str_starts_with($userMessage, '[RTC_OFFER]')) {
            $chatSession->update(['is_human_mode' => true]);
        }

        // RTC signaling bypass to avoid sending SDP/ICE data to AI
        if (str_starts_with($userMessage, '[RTC_')) {
            return response()->json([
                'answer' => '',
                'is_human_mode' => $chatSession->is_human_mode
            ]);
        }

        $cleanMessage = mb_strtolower(trim($userMessage));

        // Check if user is asking for human customer service (include letter variations & call triggers)
        $humanKeywords = [
            'خدمة عملاء', 'خدمه عملاء', 'خدمة العملاء', 'خدمه العملاء', 
            'حد يرد', 'موظف', 'ادارة', 'اداره', 'إدارة', 'إداره', 'بشر', 'انسان',
            'اتصال صوتي', 'اتصال مباشر', 'اتصال هاتفي', 'مكالمة', 'مكالمه',
            'live voice support', 'voice call', 'phone call'
        ];
        foreach ($humanKeywords as $keyword) {
            if (str_contains($cleanMessage, $keyword)) {
                $chatSession->update(['is_human_mode' => true]);
                $reply = "جاري تحويلك لأحد ممثلي خدمة العملاء... ثواني وهيكون معاك للرد على كل استفساراتك.";
                
                $existingReply = \App\Models\ChatMessage::where('session_id', $sessionToken)
                                    ->where('role', 'assistant')
                                    ->where('content', $reply)
                                    ->first();
                if (!$existingReply) {
                    \App\Models\ChatMessage::create([
                        'user_id' => null,
                        'session_id' => $sessionToken,
                        'role' => 'assistant',
                        'content' => $reply
                    ]);
                }
                return response()->json(['answer' => $reply, 'is_human_mode' => true]);
            }
        }

        // If Human Mode is ON, do NOT hit Groq!
        if ($chatSession->is_human_mode) {
            return response()->json(['answer' => '', 'is_human_mode' => true]);        $context = <<<EOT
You are 'KEMET AI', a highly prestigious, warm, and professional travel concierge working exclusively for 'KEMET Egypt Tourism', a premium Egyptian travel, accommodation, and souvenir enterprise.
Your main goal is to deliver an exceptionally natural, elite, and fast customer experience, matching the premium conversational caliber and quick wit of ChatGPT Voice Mode.

أنت ممثل خدمة عملاء وكونسيرج سياحي فاخر لشركة 'Kemet Egypt Tourism'. يجب أن تعامل العميل بمنتهى الرقي والترحيب المصري الدافئ، وتتحدث معه حصرياً باللهجة المصرية العامية الراقية والودودة جداً.

شخصيتك وأسلوبك المهني (ChatGPT Voice-Caliber Personality):
1. 🗣️ **لهجة مصرية عامية طبيعية 100% (Strict Egyptian Dialect)**:
   - يُمْنَع منعاً باتاً التحدث بالفصحى أو استخدام جمل فصحى جافة (مثل "أهلاً بك"، "كيف يمكنني"، "بكل سرور").
   - تحدث مثل صديق أو دليل سياحي مصري راقٍ ولبق وجدع. استخدم الكلمات المصرية اليومية المألوفة مثل: "أهلاً بيك يا فندم"، "يا باشا"، "إيه الأخبار"، "عيوني ليك"، "حاجة تجنن"، "بص يا صاحبي"، "منور الدنيا".
2. ⚡ **أقصى درجات الاختصار الصوتي (Extreme Conciseness - ChatGPT Voice Caliber)**:
   - يجب أن تكون ردودك قصيرة وموجزة ومباشرة للغاية لتناسب المحادثة الصوتية السريعة.
   - حدد ردك بـ **جملة واحدة أو جملتين فقط (3 جمل كحد أقصى مطلق)**!
   - يمنع تماماً كتابة فقرات طويلة أو قوائم نقطية أو جداول، لأنها تجعل محرك الصوت يتكلم لفترة طويلة وتضايق المستخدم.
   - إذا سألك العميل عن الرحلات أو الفنادق، لا تسرد له كل شيء! اذكر له خيارين أو ثلاثة فقط باختصار شديد جداً، ثم اسأله عن رغبته.
   - استثناء وحيد: فقط إذا طلب العميل صراحةً تفاصيل كاملة (مثال: "اشرحلي برنامج الرحلة بالتفصيل الممل" أو "عايز جدول تفصيلي كامل")، يمكنك وقتها كتابة رد أطول ومنسق.
3. 🧠 **منع التكلف الآلي (No AI Clichés)**:
   - لا تقل أبداً "بناءً على البيانات المتوفرة لدي" أو "أنا نموذج ذكاء اصطناعي".
   - لا تسرب أي كود برمجي أو أسماء متغيرات داخل نص الرد.
4. 🎯 **الذكاء التفاعلي القصير (Interactive Flow)**: أجب على سؤال العميل بذكاء واختصار، ثم اختم بسؤال تفاعلي واحد قصير جداً يوجهه للخطوة التالية (مثال: "تحب أظبطلك حجز رحلة الأهرامات يا باشا؟").

وظائفك وقدراتك الأساسية:
1) 🏖️ مساعدة العميل في الاختيار: ابدأ بطرح أسئلة تفاعلية ذكية وبسيطة للغاية (عايز بحر ولا آثار؟ ميزانيتك كام؟) وبناءً عليها رشح خيارات سريعة.
2) 🛒 الحجز الذكي (Booking Flow): قم بتجميع بيانات الحجز الأساسية باختصار شديد، ثم وجه العميل للدفع وتأكيد الحجز برابط مباشر مثل: [إتمام الدفع والحجز](/checkout).
3) ℹ️ إجابات فورية: أعطِ ترشيحات لأشهر الأماكن + البازارات + المطاعم باختصار شديد وبطريقة حوارية جذابة.
4) 🗓️ برامج الرحلات: لا تصمم برامج طويلة إلا لو طلب ذلك صراحة. قدم مقترحاً من سطرين فقط لرحلة سريعة.
5) 🆘 دعم ما بعد الحجز: طمئن العميل ووجهه لصفحة [حجوزاتي](/bookings) أو أخبره أن المندوب سيتواصل معه قبل الرحلة بـ 24 ساعة.
6) 💸 الـ Upselling (البيع الإضافي): اقترح نشاطاً إضافياً سريعاً وجذاباً (زي سفاري أو عشاء نيل كروز) لزيادة المبيعات بأسلوب لطيف.

قواعد هامة جداً للردود (STRICT RULES):
- 🚨 ممنوع التكرار نهائياً (NO REPETITION): اكتب الرد مرة واحدة فقط وبشكل منسق ومنسجم.
- 🚨 أسلوب المبيعات الإيجابي: ركز دائماً على الإيجابيات والتجربة الممتعة لتشجيع العميل على الحجز.
- 🚨 المحادثة الطبيعية (Small Talk): لو العميل قال كلمة عامة أو ترحيبية، رد عليه كإنسان حقيقي مرحب وودود دون الدخول في تفاصيل سياحية غير مطلوبة.
- 🚨 الهوية (Platform Identity): أنت تتحدث من داخل الموقع. استخدم روابط الأقسام لتوجيه العميل مباشرة: [حجز الفنادق](/hotels), [الرحلات](/tours), [السفاري](/safari), [المتاحف](/museums), [البازارات](/bazaars), [الفعاليات](/events), [المواصلات](/transportation).
- 🚨 حظر الرموز الخاصة المربكة للنطق صَوْتِياً (No speech-confusing markdown formatting): يُمْنَع منعاً باتاً استخدام نجوم الماركدوان مثل ** أو * أو علامات الشُرط - للتعداد النقطي، لأن محركات تحويل النص إلى صوت (Speech Synthesis) تقرأها كألفاظ مثل 'نجمة نجمة' أو 'شَرطة'. اكتب ردودك دائماً كفقرة متصلة، منسابة، وطبيعية تماماً كالبشر دون أي نجوم أو شُرط جافة لكي ينطقها محرك الصوت بشكل سليم وسلس.

--- أمثلة لأسلوب ردك العامي المصري القصير جداً (FEW-SHOT EXAMPLES) ---
1) سؤال: سلام عليكم / إيه الأخبار
ردك: وعليكم السلام يا باشا! منور كيميت مصر للسياحة. إيه الأخبار عندك؟ قولي، تحب نخطط لرحلتك الجاية فين النهاردة؟

2) سؤال: إيه الرحلات اللي عندكم؟ / إيه الرحلات
ردك: عندنا رحلات تجنن يا فندم! زي الأهرامات، رحلات نيل كروز، ورحلات سفاري الأقصر. تحب أقولك تفاصيل أي واحدة فيهم أو حابب بلد معينة؟

3) سؤال: عايز رحلة حلوة في الأقصر؟
ردك: عيوني ليك يا فندم! الأقصر دي بلد السحر والجمال. إيه رأيك في رحلة جميلة لمعبد الكرنك الصبح، وتاني يوم نزور وادي الملوك الأثري؟ تحب أحجزلك مرشد سياحي خاص يكون معاك؟

4) سؤال: الأسعار كام؟
ردك: تحت أمرك يا فندم، الأسعار بتختلف على حسب نوع الرحلة وتاريخها وعددكم. قولي كدا، ناوي تسافر إمتى وعدد الأفراد كام فرد عشان أظبطلك أحسن سعر؟

تنبيه هام جداً:
- لا تظهر الـ ID كرقم صريح للعميل في النص، اكتب اسم المكان الحقيقي.
- جغرافيا دقيقة: لا تخلط بين المحافظات. كن دقيقاً بنسبة 100%.
- إذا لاحظت أن العميل يقوم بكتابة تقييم (Review) صريح لرحلة أو فندق أو مطعم، اشكره أولاً، ويجب إضافة هذا الكود السري في آخر سطر من ردك تماماً: `[SAVE_REVIEW: item_type | item_id | rating | summary]`
EOT;�كتب الرد مرة واحدة فقط وبشكل منسق ومنسجم.
- 🚨 أسلوب المبيعات الإيجابي: ركز دائماً على الإيجابيات والتجربة الممتعة لتشجيع العميل على الحجز.
- 🚨 المحادثة الطبيعية (Small Talk): لو العميل قال كلمة عامة أو ترحيبية، رد عليه كإنسان حقيقي مرحب وودود دون الدخول في تفاصيل سياحية غير مطلوبة.
- 🚨 الهوية (Platform Identity): أنت تتحدث من داخل الموقع. استخدم روابط الأقسام لتوجيه العميل مباشرة: [حجز الفنادق](/hotels)، [الرحلات](/tours)، [السفاري](/safari)، [المتاحف](/museums)، [البازارات](/bazaars)، [الفعاليات](/events)، [المواصلات](/transportation).
- 🚨 حظر الرموز الخاصة المربكة للنطق صَوْتِياً (No speech-confusing markdown formatting): يُمْنَع منعاً باتاً استخدام نجوم الماركدوان مثل ** أو * أو علامات الشُرط - للتعداد النقطي، لأن محركات تحويل النص إلى صوت (Speech Synthesis) تقرأها كألفاظ مثل 'نجمة نجمة' أو 'شَرطة'. اكتب ردودك دائماً كفقرة متصلة، منسابة، وطبيعية تماماً كالبشر دون أي نجوم أو شُرط جافة.

--- أمثلة لأسلوب ردك التفاعلي الراقي (FEW-SHOT EXAMPLES) ---
1) سؤال: سلام عليكم / أهلاً بك
ردك: وعليكم السلام والرحمة يا فندم! أهلاً بك في كيميت مصر للسياحة. يسعدني جداً كوني كونسيرج السفر الخاص بك اليوم. كيف يمكنني مساعدتك في التخطيط لرحلتك المميزة اليوم؟

2) سؤال: عايز رحلة حلوة في الأقصر؟
ردك: بكل سرور يا فندم! مدينة الأقصر الساحرة مليئة بالتاريخ. أرشح لك برنامجاً رائعاً لزيارة معبد الكرنك العريق في اليوم الأول، ووادي الملوك المهيب في اليوم الثاني. هل تفضل أن أقوم بحجز مرشد سياحي خاص يرافقك خلال هذه الرحلة التاريخية يا فندم؟

3) سؤال: الأسعار كام؟
ردك: تحت أمرك يا فندم. الأسعار تختلف بدقة بناءً على تفضيلاتك وتاريخ رحلتك. لكي أستطيع تقديم السعر الأمثل والدقيق لك، هل تفضل السفر في تاريخ محدد وكم سيكون عدد الأفراد المرافقين لسيادتكم؟

تنبيه هام جداً:
- لا تظهر الـ ID كرقم صريح للعميل في النص، اكتب اسم المكان الحقيقي.
- جغرافيا دقيقة: لا تخلط بين المحافظات. كن دقيقاً بنسبة 100%.
- إذا لاحظت أن العميل يقوم بكتابة تقييم (Review) صريح لرحلة أو فندق أو مطعم، اشكره أولاً، ويجب إضافة هذا الكود السري في آخر سطر من ردك تماماً: `[SAVE_REVIEW: item_type | item_id | rating | summary]`

--- DATA SETS STRICTLY DEPEND ON BELOW DATA ---
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

NOTE: Never tell the user you are an AI or an LLM. Always act as 'KEMET AI' travel concierge.
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

        // Call OpenAI
        $reply = $this->aiService->ask($userMessage, $context, $history);

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

        // Save Bot Reply to Database
        \App\Models\ChatMessage::create([
            'user_id' => null, // Bot doesn't have a user ID
            'session_id' => $sessionToken,
            'role' => 'assistant',
            'content' => $reply
        ]);

        return response()->json([
            'answer' => $reply,
            'is_human_mode' => false
        ]);
    }

    public function askAuth(Request $request)
    {
        return $this->ask($request);
    }

    public function history(Request $request)
    {
        $sessionToken = $request->input('session_token');
        if (!$sessionToken) {
            return response()->json(['messages' => [], 'is_human_mode' => false]);
        }

        $messages = \App\Models\ChatMessage::where('session_id', $sessionToken)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($msg) {
                // Determine sender
                $sender = 'bot';
                if ($msg->role === 'user') $sender = 'user';
                if ($msg->role === 'admin') $sender = 'admin';

                return [
                    'id' => $msg->id,
                    'sender' => $sender,
                    'text' => $msg->content
                ];
            });

        // Also get session status
        $session = \App\Models\ChatSession::where('session_token', $sessionToken)->first();

        return response()->json([
            'messages' => $messages,
            'is_human_mode' => $session ? $session->is_human_mode : false
        ]);
    }

    private function getPromptData(string $userMessage = ''): array
    {
        // 1. Fetch or cache the full data from DB to avoid database overhead completely
        $allData = \Cache::remember('kemet_chatbot_all_data', 1800, function () {
            return [
                'tours' => \Schema::hasTable('tours') ? Tour::select('id', 'title', 'location')->limit(12)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title} ({$q->location})")->implode(', ') : '',
                'products' => \Schema::hasTable('products') ? Product::select('id', 'name', 'category')->limit(12)->get()->map(fn($q) => "[ID:{$q->id}] {$q->name} ({$q->category})")->implode(', ') : '',
                'destinations' => \Schema::hasTable('destinations') ? \App\Models\Destination::select('id', 'title')->limit(12)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title}")->implode(', ') : '',
                'activities' => \Schema::hasTable('activities') ? \App\Models\Activity::select('id', 'title', 'location')->limit(12)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title} ({$q->location})")->implode(', ') : '',
                'restaurants' => \Schema::hasTable('restaurants') ? \DB::table('restaurants')->select('id', 'name', 'location')->limit(12)->get()->map(fn($q) => "[ID:{$q->id}] {$q->name} ({$q->location})")->implode(', ') : '',
                'museums' => \Schema::hasTable('museums') ? \DB::table('museums')->select('id', 'name', 'location')->limit(12)->get()->map(fn($q) => "[ID:{$q->id}] {$q->name} ({$q->location})")->implode(', ') : '',
                'safaris' => \Schema::hasTable('safaris') ? \DB::table('safaris')->select('id', 'title', 'location')->limit(12)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title} ({$q->location})")->implode(', ') : '',
                'events' => \Schema::hasTable('events') ? \DB::table('events')->select('id', 'title', 'location')->limit(12)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title} ({$q->location})")->implode(', ') : '',
                'bazaars' => \Schema::hasTable('bazaars') ? \DB::table('bazaars')->select('id', 'title', 'location')->limit(12)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title} ({$q->location})")->implode(', ') : '',
                'transportations' => \Schema::hasTable('transportations') ? \DB::table('transportations')->select('id', 'type', 'route')->limit(12)->get()->map(fn($q) => "[ID:{$q->id}] {$q->type} ({$q->route})")->implode(', ') : '',
                'hotels' => \Schema::hasTable('hotels') ? \App\Models\Hotel::select('id', 'title', 'location')->limit(12)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title} ({$q->location})")->implode(', ') : '',
                'deals' => \Schema::hasTable('deals') ? \App\Models\Deal::select('id', 'title')->limit(12)->get()->map(fn($q) => "[ID:{$q->id}] {$q->title}")->implode(', ') : '',
            ];
        });

        // 2. If no user message, return all data as fallback
        if (empty($userMessage)) {
            return $allData;
        }

        $cleanMsg = mb_strtolower(trim($userMessage));

        // 3. Define keyword triggers for each category
        $keywords = [
            'hotels' => ['فندق', 'فنادق', 'إقامة', 'اقامه', 'سكن', 'أوتيل', 'اوتيل', 'hotel', 'stay', 'accommodation'],
            'tours' => ['رحلة', 'رحلات', 'برنامج', 'برامج', 'tour', 'package', 'trip'],
            'restaurants' => ['مطعم', 'مطاعم', 'أكل', 'اكل', 'غداء', 'عشاء', 'فطور', 'restaurant', 'food', 'eat', 'dining'],
            'safaris' => ['سفاري', 'صحراء', 'safari', 'desert'],
            'museums' => ['متحف', 'متاحف', 'آثار', 'اثار', 'تاريخ', 'museum', 'monument', 'history'],
            'products' => ['شراء', 'هدية', 'هدايا', 'منتج', 'منتجات', 'souvenir', 'shop', 'product', 'buy'],
            'deals' => ['عرض', 'عروض', 'خصم', 'خصومات', 'رخيص', 'deal', 'offer', 'discount'],
            'destinations' => ['مدينة', 'مدن', 'القاهرة', 'الأقصر', 'الاقصر', 'أسوان', 'اسوان', 'الغردقة', 'الغردقه', 'شرم', 'دهب', 'إسكندرية', 'اسكندرية', 'سيوة', 'سيوه', 'destination', 'cairo', 'luxor', 'aswan', 'hurghada', 'sharm', 'dahab', 'alexandria', 'siwa'],
            'bazaars' => ['بازار', 'بازارات', 'bazaar'],
            'events' => ['فعالية', 'فعاليات', 'حفلة', 'حفله', 'حفلات', 'مناسبة', 'مناسبه', 'event', 'concert', 'show'],
            'transportations' => ['مواصلات', 'نقل', 'توصيل', 'تاكسي', 'أتوبيس', 'اتوبيس', 'طيران', 'حجز مواصلات', 'transport', 'bus', 'taxi', 'flight', 'car'],
            'activities' => ['نشاط', 'أنشطة', 'انشطة', 'ألعاب', 'العاب', 'غطس', 'diving', 'activity', 'dive']
        ];

        $matchedData = [];
        // Keep destinations and deals as standard foundational knowledge categories (very low token cost)
        $alwaysInclude = ['destinations', 'deals'];

        foreach ($allData as $category => $value) {
            $isMatched = false;
            if (isset($keywords[$category])) {
                foreach ($keywords[$category] as $kw) {
                    if (str_contains($cleanMsg, $kw)) {
                        $isMatched = true;
                        break;
                    }
                }
            }

            if ($isMatched || in_array($category, $alwaysInclude)) {
                $matchedData[$category] = $value;
            } else {
                $matchedData[$category] = ''; // Omit from system prompt to save tokens
            }
        }

        return $matchedData;
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
