<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToppingController extends Controller
{
    public function index()
    {
        $toppings = Topping::orderBy('id', 'desc')->paginate(15);
        return view('admin.toppings.index', compact('toppings'));
    }

    public function create()
    {
        return view('admin.toppings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tentopping' => 'required|string|max:255',
            'gia' => 'required|numeric|min:0',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'trangthai' => 'boolean',
        ]);

        $data = $request->only(['tentopping', 'gia']);
        $data['trangthai'] = $request->has('trangthai');

        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads/toppings', $filename);
            $data['hinhanh'] = 'toppings/' . $filename;
        }

        Topping::create($data);

        return redirect()->route('admin.toppings.index')
            ->with('success', 'Thêm topping thành công!');
    }

    public function edit(Topping $topping)
    {
        return view('admin.toppings.edit', compact('topping'));
    }

    public function update(Request $request, Topping $topping)
    {
        $request->validate([
            'tentopping' => 'required|string|max:255',
            'gia' => 'required|numeric|min:0',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'trangthai' => 'boolean',
        ]);

        $data = $request->only(['tentopping', 'gia']);
        $data['trangthai'] = $request->has('trangthai');

        if ($request->hasFile('hinhanh')) {
            // Delete old image
            if ($topping->hinhanh) {
                Storage::delete('public/uploads/' . $topping->hinhanh);
            }
            
            $file = $request->file('hinhanh');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads/toppings', $filename);
            $data['hinhanh'] = 'toppings/' . $filename;
        }

        $topping->update($data);

        return redirect()->route('admin.toppings.index')
            ->with('success', 'Cập nhật topping thành công!');
    }

    public function destroy(Topping $topping)
    {
        // Delete image
        if ($topping->hinhanh) {
            Storage::delete('public/uploads/' . $topping->hinhanh);
        }

        $topping->delete();

        return redirect()->route('admin.toppings.index')
            ->with('success', 'Xóa topping thành công!');
    }
}
