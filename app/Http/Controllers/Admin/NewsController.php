<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = News::query();

        if ($request->has('search') && $request->search) {
            $query->where('tieude', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status) {
            $query->where('trangthai', $request->status);
        }

        $news = $query->orderBy('ngaydang', 'desc')->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.edit', ['news' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tieude' => 'required|string|max:255',
            'noidung' => 'required|string',
            'hinhanh' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['tieude', 'tomtat', 'noidung', 'trangthai']);
        
        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $filename = 'news_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads/news', $filename);
            $data['hinhanh'] = 'news/' . $filename;
        }

        $data['noibat'] = $request->has('noibat') ? 1 : 0;

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Thêm tin tức thành công!');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $request->validate([
            'tieude' => 'required|string|max:255',
            'noidung' => 'required|string',
            'hinhanh' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['tieude', 'tomtat', 'noidung', 'trangthai']);
        
        if ($request->hasFile('hinhanh')) {
            if ($news->hinhanh) {
                Storage::delete('public/uploads/' . $news->hinhanh);
            }
            
            $file = $request->file('hinhanh');
            $filename = 'news_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads/news', $filename);
            $data['hinhanh'] = 'news/' . $filename;
        }

        $data['noibat'] = $request->has('noibat') ? 1 : 0;

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Cập nhật tin tức thành công!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        
        if ($news->hinhanh) {
            Storage::delete('public/uploads/' . $news->hinhanh);
        }
        
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Xóa tin tức thành công!');
    }
}
