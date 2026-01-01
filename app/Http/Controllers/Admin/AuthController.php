<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->isAdminOrStaff()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Try to login with user table
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->isAdminOrStaff()) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }
            Auth::logout();
            return back()->with('error', 'Bạn không có quyền truy cập trang quản trị.');
        }

        // Try admin login from quantri table
        $admin = DB::table('quantri')->where('id', 1)->first();
        if ($admin && $request->email === ($admin->email ?? $admin->taikhoan) && 
            Hash::check($request->password, $admin->matkhau)) {
            // Create a virtual admin session
            session(['admin_id' => 1, 'admin_email' => $admin->email ?? $admin->taikhoan]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget(['admin_id', 'admin_email']);

        return redirect()->route('admin.login');
    }
}
