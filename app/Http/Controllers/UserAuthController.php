<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmailCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\User;

class UserAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->role != 1) {
            return response()->json([
                'success' => false,
                'errors' => ['email' => 'Access denied!'],
            ], 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password , ]) ) {
            $request->session()->regenerate();
            return response()->json(['success' => true, 'message' => 'Login successful!']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid email or password.']);
    }

    public function register(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'phone'    => 'required|string|max:20|unique:users,phone',
    ]);

    $verification_code = rand(100000, 999999);

    // Store temporarily in session
    Session::put('pending_user', [
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'phone'    => $request->phone,
        'verification_code' => $verification_code,
    ]);

    try {
        Mail::to($request->email)->send(new VerifyEmailCodeMail($verification_code));
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Unable to send verification email. Please try again later.',
        ], 500);
    }

    return response()->json([
        'success' => true,
        'message' => 'Verification code sent to your email.',
    ]);
}


public function verifyEmail(Request $request)
{
    $request->validate([
        'verification_code' => 'required|string',
    ]);

    $pendingUser = Session::get('pending_user');

    if (!$pendingUser) {
        return response()->json([
            'success' => false,
            'message' => 'Session expired. Please register again.',
        ], 440);
    }

    if ($pendingUser['verification_code'] != trim($request->verification_code)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid verification code.',
            'errors'  => ['verification_code' => ['Invalid verification code.']]
        ], 422);
    }

    // ✅ Save user correctly
    $user = User::create([
        'name'     => $pendingUser['name'],
        'email'    => $pendingUser['email'],
        'password' => $pendingUser['password'],
        'phone'    => $pendingUser['phone'],
        'email_verified_at' => now(),
    ]);

    Auth::login($user);

    Session::forget('pending_user');

    return response()->json([
        'success' => true,
        'message' => 'Email verified successfully!',
    ]);
}

    public static function logout()
    {
        // Logout user (web guard)
        if(Auth::guard('web')->check()){
            Auth::guard('web')->logout();
        }

        // Redirect to login page (or home)
        return redirect()->route('home');
    }


    // Step 1: Send Code
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $verification_code = rand(100000, 999999);

        Session::put('reset_email', $request->email);
        Session::put('reset_code', $verification_code);

        try {
            Mail::raw("Your password reset code is: {$verification_code}", function ($message) use ($request) {
                $message->to($request->email)->subject('Password Reset Code');
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to send email.']);
        }

        return response()->json(['success' => true, 'message' => 'Verification code sent to your email.']);
    }

    // Step 2: Verify Code
    public function verifyCode(Request $request)
    {
        $request->validate(['verification_code' => 'required']);
        
        if (Session::get('reset_code') != $request->verification_code) {
            return response()->json(['success' => false, 'message' => 'Invalid verification code.']);
        }

        Session::put('verified', true);
        return response()->json(['success' => true, 'message' => 'Code verified successfully.']);
    }

    // Step 3: Reset Password
    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);

        if (!Session::get('verified')) {
            return response()->json(['success' => false, 'message' => 'Verification not completed.']);
        }

        $user = User::where('email', Session::get('reset_email'))->first();
        $user->password = Hash::make($request->password);
        $user->save();

        Session::forget(['reset_email', 'reset_code', 'verified']);

        return response()->json(['success' => true, 'message' => 'Password reset successful. Please login.']);
    }
}
