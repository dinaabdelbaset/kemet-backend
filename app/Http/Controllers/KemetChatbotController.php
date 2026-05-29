<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroqService;
use App\Services\GeminiService;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class KemetChatbotController extends Controller
{
    /**
     * Fetch dynamic live chatbot context from database.
     */
    public function getContext(Request $request)
    {
        $data = [
            'destinations' => '',
            'hotels' => '',
            'tours' => '',
            'restaurants' => '',
            'safaris' => '',
            'museums' => '',
            'products' => '',
            'deals' => '',
            'bazaars' => '',
            'events' => '',
            'transportation' => '',
            'exchange_rates' => 'USD to EGP: 50.00, EUR to EGP: 54.00, GBP to EGP: 63.00',
        ];

        try {
            // Destinations
            if (Schema::hasTable('destinations')) {
                $items = DB::table('destinations')->get(['name', 'location']);
                $strs = [];
                foreach ($items as $item) {
                    $strs[] = ($item->name ?? '') . ' (' . ($item->location ?? '') . ')';
                }
                $data['destinations'] = implode(', ', $strs);
            }

            // Hotels
            if (Schema::hasTable('hotels')) {
                $items = DB::table('hotels')->get(['title', 'location', 'price_starts_from', 'rating']);
                $strs = [];
                foreach ($items as $item) {
                    $strs[] = "- " . ($item->title ?? '') . " in " . ($item->location ?? '') . ". Price starts from: " . ($item->price_starts_from ?? '') . " EGP. Rating: " . ($item->rating ?? '') . "⭐";
                }
                $data['hotels'] = implode("\n", $strs);
            }

            // Tours
            if (Schema::hasTable('tours')) {
                $items = DB::table('tours')->get(['title', 'location', 'duration', 'price', 'rating']);
                $strs = [];
                foreach ($items as $item) {
                    $strs[] = "- " . ($item->title ?? '') . " (" . ($item->location ?? '') . "). Duration: " . ($item->duration ?? '') . ". Price: " . ($item->price ?? '') . " EGP. Rating: " . ($item->rating ?? '') . "⭐";
                }
                $data['tours'] = implode("\n", $strs);
            }

            // Restaurants
            if (Schema::hasTable('restaurants')) {
                $items = DB::table('restaurants')->get(['name', 'cuisine', 'location', 'price_range_min', 'price_range_max', 'rating']);
                $strs = [];
                foreach ($items as $item) {
                    $strs[] = "- " . ($item->name ?? '') . " (" . ($item->cuisine ?? '') . ") in " . ($item->location ?? '') . ". Price range: " . ($item->price_range_min ?? '') . "-" . ($item->price_range_max ?? '') . " EGP. Rating: " . ($item->rating ?? '') . "⭐";
                }
                $data['restaurants'] = implode("\n", $strs);
            }

            // Safaris
            if (Schema::hasTable('safaris')) {
                $items = DB::table('safaris')->get(['title', 'location', 'price', 'duration', 'rating']);
                $strs = [];
                foreach ($items as $item) {
                    $strs[] = "- " . ($item->title ?? '') . " in " . ($item->location ?? '') . ". Price: " . ($item->price ?? '') . " EGP. Duration: " . ($item->duration ?? '') . ". Rating: " . ($item->rating ?? '') . "⭐";
                }
                $data['safaris'] = implode("\n", $strs);
            }

            // Museums
            if (Schema::hasTable('museums')) {
                $items = DB::table('museums')->get(['name', 'location', 'ticket_price', 'rating']);
                $strs = [];
                foreach ($items as $item) {
                    $strs[] = "- " . ($item->name ?? '') . " in " . ($item->location ?? '') . ". Tickets: " . ($item->ticket_price ?? '') . " EGP. Rating: " . ($item->rating ?? '') . "⭐";
                }
                $data['museums'] = implode("\n", $strs);
            }

            // Products
            if (Schema::hasTable('products')) {
                $items = DB::table('products')->get(['name', 'price', 'rating']);
                $strs = [];
                foreach ($items as $item) {
                    $strs[] = "- " . ($item->name ?? '') . ". Price: " . ($item->price ?? '') . " EGP. Rating: " . ($item->rating ?? '') . "⭐";
                }
                $data['products'] = implode("\n", $strs);
            }

            // Deals
            if (Schema::hasTable('deals')) {
                $items = DB::table('deals')->get(['title', 'discount_percentage', 'original_price', 'promo_code']);
                $strs = [];
                foreach ($items as $item) {
                    $strs[] = "- " . ($item->title ?? '') . ". Discount: " . ($item->discount_percentage ?? '') . "%. Original Price: " . ($item->original_price ?? '') . " EGP. Promo: " . ($item->promo_code ?? '');
                }
                $data['deals'] = implode("\n", $strs);
            }

            // Bazaars
            if (Schema::hasTable('bazaars')) {
                $items = DB::table('bazaars')->get(['title', 'location', 'description']);
                $strs = [];
                foreach ($items as $item) {
                    $strs[] = "- " . ($item->title ?? '') . " in " . ($item->location ?? '') . ". Description: " . substr(($item->description ?? ''), 0, 100) . "...";
                }
                $data['bazaars'] = implode("\n", $strs);
            }

            // Events
            if (Schema::hasTable('events')) {
                $items = DB::table('events')->get(['title', 'location', 'price', 'date']);
                $strs = [];
                foreach ($items as $item) {
                    $strs[] = "- " . ($item->title ?? '') . " in " . ($item->location ?? '') . ". Price: " . ($item->price ?? '') . " EGP. Date: " . ($item->date ?? '');
                }
                $data['events'] = implode("\n", $strs);
            }

            // Transportation
            if (Schema::hasTable('transportation')) {
                $items = DB::table('transportation')->get(['type', 'from', 'to', 'price', 'rating']);
                $strs = [];
                foreach ($items as $item) {
                    $strs[] = "- " . ($item->type ?? '') . " from " . ($item->from ?? '') . " to " . ($item->to ?? '') . ". Price: " . ($item->price ?? '') . " EGP. Rating: " . ($item->rating ?? '') . "⭐";
                }
                $data['transportation'] = implode("\n", $strs);
            }
        } catch (\Exception $e) {
            Log::error("Failed to build chatbot context: " . $e->getMessage());
        }

        return response()->json($data);
    }

    /**
     * Ask the chatbot a question (Unauthenticated or Authenticated).
     */
    public function ask(Request $request)
    {
        $messageText = $request->input('message');
        $sessionToken = $request->input('session_token');
        $history = $request->input('history', []);

        if (empty($messageText)) {
            return response()->json(['answer' => 'لم أفهم رسالتك، ممكن تعيد تاني؟ 😊', 'is_human_mode' => false]);
        }

        // Initialize / fetch Chat Session
        $session = null;
        if ($sessionToken) {
            $session = ChatSession::firstOrCreate(
                ['session_token' => $sessionToken],
                [
                    'user_id' => Auth::id(),
                    'is_human_mode' => false,
                    'is_closed' => false
                ]
            );
            
            // Sync Auth User if session was created anonymously
            if (Auth::check() && !$session->user_id) {
                $session->update(['user_id' => Auth::id()]);
            }
        }

        // Save User Message to Database
        if ($session) {
            ChatMessage::create([
                'user_id' => Auth::id(),
                'role' => 'user',
                'content' => $messageText,
                'session_id' => $session->session_token
            ]);
        }

        // Construct dynamic System Prompt with live DB context
        $basePrompt = 'أنت "KEMET AI" مساعد كيميت الذكي - مستشار سفر محترف لمنصة KEMET للسياحة المصرية.

🎯 شخصيتك: ودود, خبير سفر مصري, بتمزج عربي وإنجليزي. مش AI. بتفكر وتقترح وتساعد في الحجز.

🧠 مهاراتك:
1. TRIP PLANNER: لما حد يقول "عايز رحلة X يوم" → جدول يوم بيوم (مواعيد+أسعار+تنقلات+فنادق+مطاعم) من البيانات الحقيقية. احسب الميزانية.
2. RECOMMENDATIONS: اسأل (ميزانية/اهتمامات/مدة/مع مين) ورشح من البيانات. Budget→أرخص, Luxury→5 نجوم, تاريخ→متاحف, مغامرة→سفاري.
3. SMART SEARCH: "مطعم رومانسي"→Naguib Mahfouz. "حاجة رخيصة"→Felfela. "سمك"→Farhat. اشرح ليه.
4. BOOKING: قارن خيارات، اعطي أسعار، ووضح للعميل بالعامية المصرية خطوة بخطوة إزاي يحجز ويدفع بالطرق المتاحة والرسالة اللي هتجيله كالتالي: (1. اختاري الحاجة المراد حجزها من فنادق/رحلات/سفاري/متاحف/فعاليات/مواصلات -> 2. ادخلي واضغطي Book Now -> 3. ادفعي بالطريقة المناسبة ليكي: جنيه كاش، فيزا/ماستركارد، PayPal، أو كاش عند الوصول -> 4. أول ما تدفعي هيجيلك رسالة تأكيد SMS وإيميل فوراً بتفاصيل الحجز، وتقدري تتابعيه دايماً من صفحة حجوزاتي).
5. LIVE HELP: رد فوراً بالأسعار/المواعيد/الأماكن من البيانات.
6. PERSONALIZATION: افتكر تفضيلات المستخدم واقترح بناءً عليها.
7. EVENTS: اذكر الفعاليات المناسبة. Sound & Light 500 ج.م, Dervishes مجاناً.
8. NAVIGATION: كل وسائل المواصلات بالأسعار. Uber/Careem للتنقل الداخلي.
9. REVIEWS: استخدم التقييمات. 4.5+=ممتاز. 5000+ عميل بتقييم 4.9⭐.
10. DEALS: اذكر العروض بذكاء. قارن الخيارات. اقترح bundles.

📋 الصفحات: /flights /transportation /hotels /tours /packages /activities /safari /restaurants /events /museums /bazaars /shop /ai-planner /search /wishlist /bookings /checkout /explore/:city /reviews /contact /support
💰 كل الأسعار بالجنيه المصري (ج.م). حوّل بأسعار الصرف لما يُطلب.
💳 دفع: جنيه كاش, فيزا/ماستركارد, PayPal, كاش عند الوصول.
🗣️ رد بنفس لغة المستخدم.
🏆 افهم→اسأل→رشح→قارن→ساعد في الحجز→تابع!';

        $contextResponse = $this->getContext($request);
        $contextData = $contextResponse->getData(true);

        $liveDataStrs = [];
        if (!empty($contextData['destinations'])) $liveDataStrs[] = "📍 DESTINATIONS: " . $contextData['destinations'];
        if (!empty($contextData['hotels'])) $liveDataStrs[] = "🏨 HOTELS (with live prices):\n" . $contextData['hotels'];
        if (!empty($contextData['tours'])) $liveDataStrs[] = "🏛️ TOURS & PACKAGES (with prices):\n" . $contextData['tours'];
        if (!empty($contextData['restaurants'])) $liveDataStrs[] = "🍽️ RESTAURANTS (with price ranges):\n" . $contextData['restaurants'];
        if (!empty($contextData['safaris'])) $liveDataStrs[] = "🏜️ SAFARIS & ACTIVITIES (with prices):\n" . $contextData['safaris'];
        if (!empty($contextData['museums'])) $liveDataStrs[] = "🎭 MUSEUMS & LANDMARKS (with ticket prices):\n" . $contextData['museums'];
        if (!empty($contextData['products'])) $liveDataStrs[] = "🛍️ SOUVENIR SHOP (with prices):\n" . $contextData['products'];
        if (!empty($contextData['deals'])) $liveDataStrs[] = "🔥 CURRENT DEALS & OFFERS:\n" . $contextData['deals'];
        if (!empty($contextData['bazaars'])) $liveDataStrs[] = "🛒 BAZAARS & MARKETS:\n" . $contextData['bazaars'];
        if (!empty($contextData['events'])) $liveDataStrs[] = "🎪 EVENTS & FESTIVALS (with prices):\n" . $contextData['events'];
        if (!empty($contextData['transportation'])) $liveDataStrs[] = "🚗 TRANSPORTATION OPTIONS (with prices in EGP):\n" . $contextData['transportation'];
        if (!empty($contextData['exchange_rates'])) $liveDataStrs[] = "💱 LIVE EXCHANGE RATES:\n" . $contextData['exchange_rates'];

        $systemContext = $basePrompt;
        if (count($liveDataStrs) > 0) {
            $systemContext .= "\n\n--- LIVE DATABASE PRICES (use these exact numbers when users ask) ---\n" . implode("\n\n", $liveDataStrs);
        }

        // Fill history from DB if not provided
        if (empty($history) && $session) {
            $dbMessages = ChatMessage::where('session_id', $session->session_token)
                ->where('content', '!=', $messageText)
                ->orderBy('created_at', 'asc')
                ->take(10)
                ->get();
            foreach ($dbMessages as $msg) {
                $history[] = [
                    'role' => $msg->role,
                    'content' => $msg->content
                ];
            }
        }

        // Send to LLM
        $groq = new GroqService();
        $gemini = new GeminiService();
        $answer = null;

        try {
            $answer = $groq->ask($messageText, $systemContext, $history);
            
            // If Groq has error or connection issues, fall back to Gemini
            if (!$answer || 
                str_starts_with($answer, 'Groq Connection Error') || 
                str_starts_with($answer, 'Groq Structure Error') || 
                str_starts_with($answer, 'System Exception')
            ) {
                Log::warning("Groq failed with response: " . $answer . ". Falling back to Gemini...");
                $answer = $gemini->ask($messageText, $systemContext);
            }
        } catch (\Exception $e) {
            Log::error("Groq thrown exception: " . $e->getMessage() . ". Falling back to Gemini...");
            try {
                $answer = $gemini->ask($messageText, $systemContext);
            } catch (\Exception $geminiEx) {
                Log::error("Gemini failed too: " . $geminiEx->getMessage());
                $answer = "معذرة، أواجه مشكلة مؤقتة في الاتصال بخدمات الذكاء الاصطناعي. يرجى المحاولة مرة أخرى بعد قليل.";
            }
        }

        // Check if Gemini failed too
        if (empty($answer) || 
            str_starts_with($answer, 'Gemini Connection Error') || 
            str_starts_with($answer, 'Gemini Structure Error') || 
            str_starts_with($answer, 'System Exception')
        ) {
            Log::error("All AI services failed. Answer is: " . $answer);
            $answer = "أهلاً بك! أنا هنا لمساعدتك في التخطيط لرحلتك إلى مصر. يرجى تكرار سؤالك مرة أخرى، أو مراجعة الاتصال بالإنترنت.";
        }

        // Save Assistant Response to Database
        if ($session && !empty($answer)) {
            ChatMessage::create([
                'user_id' => null,
                'role' => 'assistant',
                'content' => $answer,
                'session_id' => $session->session_token
            ]);
        }

        return response()->json([
            'answer' => $answer,
            'is_human_mode' => $session ? (bool)$session->is_human_mode : false
        ]);
    }

    /**
     * Authenticated wrapper for asking the chatbot.
     */
    public function askAuth(Request $request)
    {
        return $this->ask($request);
    }

    /**
     * Securely fetch chat history from DB for a given session.
     */
    public function history(Request $request)
    {
        $sessionToken = $request->query('session_token');
        if (!$sessionToken) {
            return response()->json(['messages' => [], 'is_human_mode' => false]);
        }

        $session = ChatSession::where('session_token', $sessionToken)->first();
        if (!$session) {
            return response()->json(['messages' => [], 'is_human_mode' => false]);
        }

        $dbMessages = ChatMessage::where('session_id', $sessionToken)
            ->orderBy('created_at', 'asc')
            ->get();

        $formatted = [];
        foreach ($dbMessages as $msg) {
            $formatted[] = [
                'id' => $msg->id,
                'sender' => $msg->role === 'user' ? 'user' : 'bot',
                'role' => $msg->role,
                'text' => $msg->content,
                'content' => $msg->content,
                'created_at' => $msg->created_at ? $msg->created_at->toIso8601String() : null,
            ];
        }

        return response()->json([
            'messages' => $formatted,
            'is_human_mode' => (bool)$session->is_human_mode
        ]);
    }
}
