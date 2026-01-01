<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Comment::with(['user', 'product']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('trangthai', $request->status);
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating) {
            $query->where('danhgia', $request->rating);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('noidung', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('hoten', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('product', function($q2) use ($search) {
                      $q2->where('tenmon', 'like', '%' . $search . '%');
                  });
            });
        }

        $comments = $query->orderBy('ngaytao', 'desc')->paginate(15);

        return view('admin.comments.index', compact('comments'));
    }

    public function updateStatus(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['trangthai' => $request->status]);

        return back()->with('success', 'Cập nhật trạng thái bình luận thành công!');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Xóa bình luận thành công!');
    }

    public function bulkAction(Request $request)
    {
        $ids = $request->ids ?? [];
        $action = $request->action;

        if (empty($ids)) {
            return back()->with('error', 'Vui lòng chọn ít nhất một bình luận!');
        }

        switch ($action) {
            case 'approve':
                Comment::whereIn('id', $ids)->update(['trangthai' => 'Đã duyệt']);
                return back()->with('success', 'Đã duyệt ' . count($ids) . ' bình luận!');
            case 'hide':
                Comment::whereIn('id', $ids)->update(['trangthai' => 'Bị ẩn']);
                return back()->with('success', 'Đã ẩn ' . count($ids) . ' bình luận!');
            case 'delete':
                Comment::whereIn('id', $ids)->delete();
                return back()->with('success', 'Đã xóa ' . count($ids) . ' bình luận!');
            default:
                return back()->with('error', 'Hành động không hợp lệ!');
        }
    }
}
