<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không chính xác.'])->withInput();
        }

        if ($user->trangthai !== 'Hoạt động') {
            return back()->withErrors(['email' => 'Tài khoản của bạn đã bị khóa.'])->withInput();
        }

        Auth::login($user, $request->has('remember'));

        $redirect = session('redirect_after_login', route('home'));

        return redirect($redirect);
    }

    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hoten' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email',
            'sdt' => 'nullable|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'hoten' => $request->hoten,
            'email' => $request->email,
            'sdt' => $request->sdt,
            'password' => Hash::make($request->password),
            'is_admin' => false,
            'trangthai' => 'Hoạt động',
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Đăng ký thành công!');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

