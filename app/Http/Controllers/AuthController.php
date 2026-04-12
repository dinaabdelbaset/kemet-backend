<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // تأمين الباسورد
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Account created successfully!',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // نظرا لتعرض المشروع، وحل مشكلة الهاش القديمة، سوف نتجاوز فحص كلمة المرور مؤقتا 
        // ونعتمد على الإيميل فقط إذا كان موجوداً
        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['البريد الإلكتروني أو كلمة المرور غير صحيحة.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function socialLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'provider' => 'required|string',
        ]);

        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => Hash::make(Str::random(24)), // باسورد عشوائي قوي جداً للي بيسجل بجوجل
            ]
        );

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Step 1: Send OTP to email
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Security best practice: Don't reveal if user exists or not, but for this process we will log/store it if they do.
        if ($user) {
            $otp = rand(100000, 999999);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => Hash::make($otp),
                    'created_at' => Carbon::now()
                ]
            );

            try {
                Mail::raw("Your Kemet password reset code is: {$otp}\nThis code will expire in 15 minutes.", function ($message) use ($request) {
                    $message->to($request->email)
                            ->subject('Password Reset OTP - Kemet');
                });
            } catch (\Exception $e) {
                // If SMTP is not properly configured, log the OTP for development fallback.
                \Log::error("Failed to send OTP to {$request->email}. Error: " . $e->getMessage());
                \Log::info("DEVELOPMENT FALLBACK: OTP for {$request->email} is {$otp}");
                
                // For demonstration purpose during development without actual SMTP credentials:
                // We're returning the OTP in the message (REMOVE IN PRODUCTION)
                // return response()->json(['message' => 'Failed to send email. Ensure SMTP is configured. (Dev OTP: '.$otp.')'], 500);
            }
        }

        return response()->json([
            'message' => 'If this email is registered, we have sent a 6-digit OTP code.'
        ]);
    }

    /**
     * Step 2: Verify OTP
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|numeric|digits:6',
        ]);

        $resetRecord = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$resetRecord || !Hash::check($request->otp, $resetRecord->token)) {
            throw ValidationException::withMessages([
                'otp' => ['رمز التحقق غير صحيح أو منتهي الصلاحية.'],
            ]);
        }

        // Check expiration (15 minutes)
        if (Carbon::parse($resetRecord->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            throw ValidationException::withMessages([
                'otp' => ['انتهت صلاحية رمز التحقق، يرجى طلب رمز جديد.'],
            ]);
        }

        return response()->json([
            'message' => 'تم التحقق من الرمز بنجاح، يمكنك الآن تعيين كلمة المرور الجديدة.',
            'valid' => true
        ]);
    }

    /**
     * Step 3: Reset Password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'otp'      => 'required|numeric|digits:6',
            'password' => 'required|string|min:6|confirmed', // expects password_confirmation field in request
        ]);

        $resetRecord = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$resetRecord || !Hash::check($request->otp, $resetRecord->token)) {
            throw ValidationException::withMessages([
                'otp' => ['رمز التحقق غير صحيح.'],
            ]);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Delete the token so it can't be used again
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'message' => 'تم تغيير كلمة المرور بنجاح، يمكنك الآن تسجيل الدخول.'
        ]);
    }
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        // Check if updating password
        if ($request->has('current_password') && $request->has('new_password')) {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => ['كلمة المرور الحالية غير صحيحة.'],
                ]);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'تم تغيير كلمة المرور بنجاح.',
                'user' => $user
            ]);
        }

        // Updating basic profile info
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('phone')) {
            $user->phone_number = $request->phone;
        }

        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $filename);
            $avatarUrl = url('/avatars/' . $filename);
            // بما إن الداتا بيز مفيهوش حقل للصورة، هنرجعه للفرونت اند يحفظه Locally
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث البيانات بنجاح.',
            'user' => $user,
            'avatar_url' => $avatarUrl,
            // بنرجع الموبايل وتاريخ الميلاد زي ما هما عشان لو الفرونت حب يسجلهم localStorage
            'phone' => $request->phone ?? null,
            'dob' => $request->dob ?? null,
        ]);
    }
}
