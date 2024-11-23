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
    
    public function registerView()
    {
        try {
            return view('auth.register');
        } catch (\Exception $e) {
            return abort(404, "Something went wrong");
        }
    }

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

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        // $user->verification_token = Str::random(60); // Commented out email verification logic
        // $user->token_expires_at = Carbon::now()->addHour(); // Commented out email verification logic
        $user->is_verified = 1; // Automatically mark as verified (bypassing email verification)
        $user->save();

        // Send verification email - Commented out
        // $this->sendVerificationMail($user); // Commented out email verification logic

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }

//     protected function sendVerificationMail($user)
// {
    // try {
    //     $verificationUrl = url('/verify/' . $user->verification_token);
    //     Mail::send('mail.verification', ['name' => $user->name, 'url' => $verificationUrl], function($message) use ($user) {
    //         $message->to($user->email);
    //         $message->subject('Email Verification');
    //     });

    // } catch (\Exception $e) {
    //     // Handle the error or log it
    //     return back()->with('Failed to send verification email: ' . $e->getMessage());
    // }
    // }

    //  public function verify($token){

    //     $user  = User::where('verification_token', $token)->first();

    //     if(!$user){
    //         return back()->with('error', 'Invalid token');
    //     }
    //     if($user->token_expires_at < Carbon::now()){

    //         $msg = 'Verification token has been expired. Please request a new Verification email.';
    //         return view('auth.verification-message', compact('msg'));

    //     }
    //     $user->is_verified = 1;
    //     $user->email_verified_at = Carbon::now();
    //     $user->verification_token = null;
    //     $user->token_expires_at = null;
    //     $user->save();

    //     $msg  = "Email Verified Successfully!";
    //     return view('auth.verification-message', compact('msg'));
    //  }

// login methods
public function loginView(){
    return view('auth.login');
}

public function login(Request $request){
   
    try{
         // Trim inputs
         $request->merge([
            'email' => trim($request->email),
            'password' => trim($request->password),
        ]);
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            
            if(Auth::user()->is_verified == 0){
                Auth::logout();
                return back()->with('error', 'Please Verify your email');   
            }

            if(Auth::user()->is_admin == 1){
                return redirect()->route('dashboard');
            }else{
                return redirect()->route('home');
            }
        }else{
            return back()->with('error', 'Invalid email or password');
        }
        
    }catch(\Exception $e){
        return back()->with('msg', $e->getMessage());
    }
}


// forgot password

public function forgotView(){
    return view('auth.forgot-password');
}


public function forgot(Request $request){
    $request->validate([
        'email' => 'required|email',
    ]);


    $user = User::where('email', $request->email)->first();

    if(!$user){

        return back()->with('error', 'Email is not exists!');
    }

  $token = Str::random(50);
  $url = url('/reset-password/'.$token);

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

  Mail::send('mail.forgot-password',['url' => $url], function($message) use($user){
    $message->to($user->email);
    $message->subject('Reset Password');
  });
    
  return back()->with('success', 'Please check your email to reset your password');


}


// Reset Password View

public function resetPasswordView($token){
    
    $resetData =  PasswordReset::where('token', $token)->first();

    if(!$resetData){

        return abort(404, 'Something went wrong');
    }

    $user = User::where('email', $resetData->email)->first();

    return view('auth.reset-password', compact('user'));
}

// update password

public function resetPassword(Request $request){
    $request->validate([
        'password' => 'required|confirmed',
        'id' => 'required',
    ]);

    $user  = User::find($request->id);
    $user->password = Hash::make($request->password);
    $user->save();

    PasswordReset::where('email', $user->email)->delete();

    return redirect()->route('passwordUpdated');


}


public function passwordUpdated(){

    return view('auth.password-updated');
}



    
}
