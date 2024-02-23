<?php


namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;
use App\Services\LoginService;
use App\Services\PasswordResetService;
use App\Services\VerifyEmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    protected $registerService;
    protected $loginService;
    protected $passwordResetService;
    protected $verifyEmailService;

    public function __construct(
        RegisterService $registerService,
        LoginService $loginService,
        PasswordResetService $passwordResetService,
        VerifyEmailService $verifyEmailService
    ) {
        $this->registerService = $registerService;
        $this->loginService = $loginService;
        $this->passwordResetService = $passwordResetService;
        $this->verifyEmailService = $verifyEmailService;
    }
    public function showRegistrationForm()
    {
        // dd('Reached showRegistrationForm');
        return view('register');
    }
   
    public function register(RegisterRequest $request)
    {
        try {
            // dd('Reached register method');
            $data = $request->validated();
            $user = $this->registerService->register($data);
            auth()->login($user);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Registration failed. Please try again.');
        }
    }


    public function showLoginForm()
    {
        // dd('Reached showRegistrationForm');
        return view('login');
    }

    public function login(Request $request)
    {
          
        $credentials = $request->only('email', 'password');

        if ($this->loginService->attempt($credentials)) {
            return redirect()->intended('/');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $credentials = $request->only('email');
        $this->passwordResetService->sendResetLink($credentials);

        return redirect()->back()->with('status', 'Password reset link sent!');
    }

    // public function resetPassword(Request $request)
    // {
    //     $credentials = $request->only('email', 'token');
    //     $password = $request->input('password');

    //     if ($this->passwordResetService->resetPassword($credentials, $password)) {
    //         return redirect('/login')->with('status', 'Password reset successful!');
    //     } else {
    //         return redirect()->back()->with('error', 'Invalid credentials or expired token');
    //     }
    // }
    public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $response = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $this->resetPasswordAndNotify($user, $password);
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return view('auth.passwords.verify');
        } else {
            return redirect()->back()->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
        }
    }


    protected function resetPasswordAndNotify($user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();
        
    }


    public function verifyEmail(Request $request)
    {
        $user = $request->user();

        if ($this->verifyEmailService->verify($user)) {
            return redirect('/')->with('status', 'Email verified successfully!');
        } else {
            return redirect('/')->with('error', 'Email already verified or invalid request');
        }
    }
}
