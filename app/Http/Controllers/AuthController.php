<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Cast\Bool_;

class AuthController extends Controller
{
    private function attempt($username, $password)
    {
        $user = User::query()
            ->where('email', $username)
            ->orWhere('mobile', $username);

        if ($user->exists()) {
            if (Hash::check($password, $user->first()->getAuthPassword())) {
                Auth::login($user->first());
                return \auth()->check();
            }
        }
        return redirect()->route('login');
    }

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

        if ($this->attempt($request->get('email'), $request->get('password'))) //Auth::login($user);
        {
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
        if ($this->attempt($request->get('username'), $request->get('password'))) //Auth::login($user);
        {
            $username = $request->get('username');
            $password = $request->get('password');
            $user = User::query()
                ->where('email', $username)
                ->orWhere('mobile', $username)
                ->first();
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
