<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeMail;

class AdminAuthController extends Controller
{
    public static function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public static function authenticate(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email', // Check if email exists in instructors table
            'password' => 'required',
        ], [
            'email.exists' => 'Invalid Email Address.', // Custom error message for email not found
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check email and password
        $user = User::where('email', $request->email)->first();
        if($user && $user->role !== 0) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'email' => 'Access denied! Admins only.',
                ],
            ], 422);
        }
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors' => [
                    $user ? 'password' : 'email' => $user ? 'Incorrect password.' : 'Invalid Email.',
                ],
            ], 422);
        }

        if($user->status == 2){
            return response()->json([
                'success' => false,
                'errors' => [
                    'email' => 'Your account has been blocked. Please contact support.',
                ],
            ], 422);
        }

        // Authenticate the user with the instructor guard
        Auth::guard('admin')->login($user);


        return response()->json([
            'success' => true,
            'message' => 'Admin Login successful!',
            'redirect' => route('admin.dashboard'),
        ]);
    }

    public static function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }

    public static function forgotPass(){
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.forgotPass');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email|exists:users,email',
        ]);

        $code = rand(100000, 999999);
        session(['reset_code' => $code]);
        session(['identifier' => $request->email ?? $request->phone]);

        // send via mail or sms (dummy)
        if ($request->email) {
            Mail::to($request->email)->send(new CodeMail($code));
        }

        return response()->json(['message' => 'Verification code sent successfully']);
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required']);
        
        if ($request->code == session('reset_code')) {
            return response()->json(['message' => 'Code verified']);
        }

        return response()->json(['message' => 'Invalid code'], 422);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $identifier = session('identifier');

        $user = User::where('email', $identifier)->orWhere('mobile', $identifier)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget(['reset_code', 'identifier']);

        return redirect(route('login'))->with('success','Password updated successfully');
    }
}
