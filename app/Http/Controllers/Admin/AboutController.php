<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = About::orderBy('thutu');
        
        if ($request->search) {
            $query->where('tieude', 'like', '%' . $request->search . '%');
        }
        
        if ($request->status) {
            $query->where('trangthai', $request->status);
        }
        
        $abouts = $query->paginate(10);
        return view('admin.about.index', compact('abouts'));
    }

    public function create()
    {
        return view('admin.about.edit', ['about' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tieude' => 'required|string|max:255',
            'noidung' => 'required|string',
            'hinhanh' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['tieude', 'noidung', 'thutu', 'trangthai']);
        
        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $filename = 'about_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads/about', $filename);
            $data['hinhanh'] = 'about/' . $filename;
        }

        About::create($data);

        return redirect()->route('admin.about.index')->with('success', 'Thêm giới thiệu thành công!');
    }

    public function edit($id)
    {
        $about = About::findOrFail($id);
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $about = About::findOrFail($id);

        $request->validate([
            'tieude' => 'required|string|max:255',
            'noidung' => 'required|string',
            'hinhanh' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['tieude', 'noidung', 'thutu', 'trangthai']);
        
        if ($request->hasFile('hinhanh')) {
            if ($about->hinhanh) {
                Storage::delete('public/uploads/' . $about->hinhanh);
            }
            
            $file = $request->file('hinhanh');
            $filename = 'about_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads/about', $filename);
            $data['hinhanh'] = 'about/' . $filename;
        }

        $about->update($data);

        return redirect()->route('admin.about.index')->with('success', 'Cập nhật giới thiệu thành công!');
    }

    public function destroy($id)
    {
        $about = About::findOrFail($id);
        
        if ($about->hinhanh) {
            Storage::delete('public/uploads/' . $about->hinhanh);
        }
        
        $about->delete();

        return redirect()->route('admin.about.index')->with('success', 'Xóa giới thiệu thành công!');
    }
}
