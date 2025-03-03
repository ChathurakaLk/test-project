<?php

namespace App\Http\Controllers;

use App\Http\Handlers\UserHandler;
use App\Http\Requests\LoginUserReqeust;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(private UserHandler $userHandler)
    {
        //
    }

    public function dashboard()
    {
        $authUser = Auth::user();
        $users = $this->userHandler->HandleGetAllUsers();
        return view('dashboard.index', compact('users', 'authUser'));
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function loginForm()
    {
        return view('auth.login');

    }
    public function login(LoginUserReqeust $request)
    {
        $credentials = $request->validated();
        $user = $this->userHandler->HandleLoginUser($credentials);

        if ($user) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials. Please try again.',
        ])->withInput();
    }

    public function register(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->userHandler->HandleRegisterUser($validatedData);
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }

    public function logOut(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form')->with('success', 'Logged out successfully!');
    }
}
