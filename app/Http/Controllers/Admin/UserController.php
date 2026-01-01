<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('hoten', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('sdt', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('trangthai', $request->status);
        }

        // Filter by role (0, 1, 2)
        if ($request->has('role') && $request->role !== '' && $request->role !== null) {
            $query->where('is_admin', (int)$request->role);
        }

        $users = $query->orderBy('id', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Update user role via AJAX
     */
    public function updateRole(Request $request, $id)
    {
        // Only admin can change roles
        if (!auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Bạn không có quyền thay đổi vai trò.'], 403);
        }

        $user = User::findOrFail($id);
        
        // Cannot change own role
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Không thể thay đổi vai trò của chính mình.'], 400);
        }

        $newRole = (int)$request->input('role');
        
        // Validate role value
        if (!in_array($newRole, [0, 1, 2])) {
            return response()->json(['success' => false, 'message' => 'Vai trò không hợp lệ.'], 400);
        }

        // Prevent removing last admin
        if ($user->is_admin == 1 && $newRole != 1 && User::where('is_admin', 1)->count() <= 1) {
            return response()->json(['success' => false, 'message' => 'Không thể bỏ quyền admin cuối cùng.'], 400);
        }

        $user->update(['is_admin' => $newRole]);

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật vai trò thành công.',
            'role_name' => $user->getRoleName()
        ]);
    }

    public function create()
    {
        return view('admin.users.edit', ['user' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hoten' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'sdt' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $data = $request->only(['hoten', 'email', 'sdt', 'trangthai']);
        $data['password'] = Hash::make($request->password);
        $data['is_admin'] = (int)$request->input('is_admin', 0);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = 'avatar_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads/avatars', $filename);
            $data['avatar'] = 'avatars/' . $filename;
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Thêm người dùng thành công!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'hoten' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $id,
            'sdt' => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        $data = $request->only(['hoten', 'email', 'sdt', 'trangthai']);
        
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        
        $data['is_admin'] = (int)$request->input('is_admin', 0);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/uploads/' . $user->avatar);
            }
            
            $file = $request->file('avatar');
            $filename = 'avatar_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads/avatars', $filename);
            $data['avatar'] = 'avatars/' . $filename;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->is_admin && User::where('is_admin', 1)->count() <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Không thể xóa admin cuối cùng!');
        }
        
        if ($user->avatar) {
            Storage::delete('public/uploads/' . $user->avatar);
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Xóa người dùng thành công!');
    }
}
