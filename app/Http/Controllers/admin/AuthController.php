<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\PasswordReset;

class AuthController extends Controller
{
    // Registration Method
    public function register(Request $request)
    {
        // Trim inputs
        $request->merge([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'phone' => trim($request->phone),
            'password' => trim($request->password),
            'password_confirmation' => trim($request->password_confirmation),
        ]);

        // Validate the user input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric|digits:10',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
        ]);

        // Save the user to the database
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->is_admin = 0; // Default to regular user
        $user->is_verified = 1; // Mark as verified by default
        $user->save();

        // Log the user in automatically
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome to the dashboard.');
    }

    // Login View Method
    public function loginView()
    {
        return view('auth.login');  
    }

    // Login Method
    public function login(Request $request)
    {
        try {
            // Trim inputs
            $request->merge([
                'email' => trim($request->email),
                'password' => trim($request->password),
            ]);

            // Validate login inputs
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Attempt login
            $credentials = $request->only(['email', 'password']);
            if (Auth::attempt($credentials)) {
                // Check if the user is verified
                if (Auth::user()->is_verified == 0) {
                    Auth::logout();
                    return back()->with('error', 'Please verify your email.');
                }

                // Redirect based on user type
                if (Auth::user()->is_admin == 1) {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('user.dashboard');
                }
            } else {
                return back()->with('error', 'Invalid email or password');
            }
        } catch (\Exception $e) {
            return back()->with('msg', $e->getMessage());
        }
    }

    // Forgot Password View Method
    public function forgotView()
    {
        return view('auth.forgot-password');
    }

    // Forgot Password Method
    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email does not exist!');
        }

        $token = Str::random(50);
        $url = url('/reset-password/' . $token);

        PasswordReset::updateOrInsert(
            [
                'email' => $user->email,
            ],
            [
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        Mail::send('mail.forgot-password', ['url' => $url], function($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Password');
        });

        return back()->with('success', 'Please check your email to reset your password.');
    }

    // Reset Password View Method
    public function resetPasswordView($token)
    {
        $resetData = PasswordReset::where('token', $token)->first();

        if (!$resetData) {
            return abort(404, 'Something went wrong');
        }

        $user = User::where('email', $resetData->email)->first();

        return view('auth.reset-password', compact('user'));
    }

    // Reset Password Method
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
            'id' => 'required',
        ]);

        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->save();

        PasswordReset::where('email', $user->email)->delete();

        return redirect()->route('passwordUpdated');
    }

    // Password Updated View Method
    public function passwordUpdated()
    {
        return view('auth.password-updated');
    }
}
