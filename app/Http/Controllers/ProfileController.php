<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user profile.
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate based on what fields are being updated
        $rules = [];
        
        if ($request->has('hoten')) {
            $rules['hoten'] = 'required|string|max:100';
        }
        
        if ($request->has('email')) {
            $rules['email'] = 'required|email|unique:user,email,' . $user->id;
        }
        
        if ($request->has('sdt')) {
            $rules['sdt'] = 'nullable|string|max:15';
        }
        
        if ($request->hasFile('avatar')) {
            $rules['avatar'] = 'image|max:2048';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = [];

        if ($request->has('hoten')) {
            $data['hoten'] = $request->hoten;
        }

        if ($request->has('email')) {
            $data['email'] = $request->email;
        }

        if ($request->has('sdt')) {
            $data['sdt'] = $request->sdt;
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/uploads/' . $user->avatar);
            }

            // Store avatar with consistent path
            $file = $request->file('avatar');
            $filename = 'avatar_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads/avatars', $filename);
            $data['avatar'] = 'avatars/' . $filename;
        }

        if (!empty($data)) {
            $user->update($data);
        }

        return back()->with('success', 'Đã cập nhật thông tin thành công.');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Đã đổi mật khẩu thành công.');
    }
}

