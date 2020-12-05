<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        if (!\auth()->check())
            return view('auth.register');
        else
            return redirect()->back()->with('status', 'داداش شما که لاگ اینی!!!');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        if (Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ])) //Auth::login($user);
        {
            $user = \auth()->user();
            return redirect()->route('tasks.index')->with('status', "$user->name خوش آمدید ");
        } else
            return redirect()->back()->with('error', 'چنین کاربری از قبل وجود دارد!!!');
    }

    public function showLogin()
    {
        if (!\auth()->check())
            return view('auth.login');
        else
            return redirect()->back()->with('status', 'داداش شما که لاگ اینی!!!');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ])) //Auth::login($user);
        {
            $user = \auth()->user();
            return redirect()->route('tasks.index')->with('status', "$user->name خوش آمدید ");
        } else
            return redirect()->back()->with('error', 'ایمیل یا رمز عبور وارد شده صحیح نمی باشد');
    }

    public function logout()
    {
        if (auth()->check()) {
            auth()->logout();
            return redirect()->route('login');
        } else
            return redirect()->route('login')->with('status', 'شما وارد نشده اید که بخواهید خارج شوید!');
    }
}
