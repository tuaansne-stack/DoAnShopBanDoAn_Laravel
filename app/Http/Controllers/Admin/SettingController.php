<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $settings = DB::table('quantri')->first();
        $paymentMethods = DB::table('phuongthucthanhtoan')->orderBy('id')->get();
        $bankInfo = DB::table('thongtinthanhtoan')->orderBy('id')->get();
        $shippingMethods = DB::table('phuongthucvanchuyen')->orderBy('id')->get();
        
        return view('admin.settings.index', compact('settings', 'paymentMethods', 'bankInfo', 'shippingMethods'));
    }

    public function updateGeneral(Request $request)
    {
        $request->validate([
            'shop_info' => 'nullable|string|max:255',
            'website_info' => 'nullable|string',
            'address' => 'nullable|string',
            'hotline' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        DB::table('quantri')->where('id', 1)->update($request->only([
            'shop_info', 'website_info', 'address', 'hotline', 'email'
        ]));

        return back()->with('success', 'Cập nhật thông tin chung thành công!');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,ico|max:1024',
        ]);

        // Get or create settings record
        $settings = DB::table('quantri')->first();
        if (!$settings) {
            DB::table('quantri')->insert([
                'id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $settings = DB::table('quantri')->first();
        }

        $updateData = [];
        $messages = [];

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            if ($logoFile->isValid()) {
                // Delete old logo
                if (!empty($settings->logo)) {
                    Storage::delete('public/uploads/' . $settings->logo);
                }
                
                $logoName = 'logo_' . uniqid() . '.' . $logoFile->getClientOriginalExtension();
                $logoFile->storeAs('public/uploads', $logoName);
                $updateData['logo'] = $logoName;
                $messages[] = 'Logo đã được cập nhật.';
            }
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $faviconFile = $request->file('favicon');
            if ($faviconFile->isValid()) {
                // Delete old favicon
                if (!empty($settings->favicon)) {
                    Storage::delete('public/uploads/' . $settings->favicon);
                }
                
                $faviconName = 'favicon_' . uniqid() . '.' . $faviconFile->getClientOriginalExtension();
                $faviconFile->storeAs('public/uploads', $faviconName);
                $updateData['favicon'] = $faviconName;
                $messages[] = 'Favicon đã được cập nhật.';
            }
        }

        if (!empty($updateData)) {
            $updateData['updated_at'] = now();
            DB::table('quantri')->where('id', $settings->id)->update($updateData);
            return back()->with('success', implode(' ', $messages));
        }

        return back()->with('warning', 'Vui lòng chọn ít nhất một file để upload!');
    }

    public function updateSocial(Request $request)
    {
        DB::table('quantri')->where('id', 1)->update($request->only([
            'facebook', 'twitter', 'instagram', 'zalo', 'pinterest', 'linkedin', 'tiktok'
        ]));

        return back()->with('success', 'Cập nhật liên kết mạng xã hội thành công!');
    }

    public function updatePayment(Request $request)
    {
        $errors = [];
        
        // Update existing payment methods
        if ($request->has('payment_methods')) {
            foreach ($request->payment_methods as $id => $data) {
                if (isset($data['delete']) && $data['delete'] == 1) {
                    // Check if payment method is in use
                    $inUse = DB::table('hoadon')->where('pttt_id', $id)->exists();
                    if ($inUse) {
                        $errors[] = 'Không thể xóa phương thức thanh toán đang được sử dụng bởi đơn hàng.';
                    } else {
                        DB::table('phuongthucthanhtoan')->where('id', $id)->delete();
                    }
                } else {
                    DB::table('phuongthucthanhtoan')->where('id', $id)->update([
                        'ten_pttt' => $data['name'] ?? '',
                        'mota' => $data['description'] ?? '',
                        'trangthai' => isset($data['status']) ? 1 : 0,
                    ]);
                }
            }
        }

        // Add new payment method
        if ($request->has('new_payment') && !empty($request->new_payment['name'])) {
            DB::table('phuongthucthanhtoan')->insert([
                'ten_pttt' => $request->new_payment['name'],
                'mota' => $request->new_payment['description'] ?? '',
                'trangthai' => isset($request->new_payment['status']) ? 1 : 0,
            ]);
        }

        if (!empty($errors)) {
            return back()->with('error', implode(' ', $errors));
        }

        return back()->with('success', 'Cập nhật phương thức thanh toán thành công!');
    }

    public function updateBank(Request $request)
    {
        // Update existing bank info
        if ($request->has('bank_info')) {
            foreach ($request->bank_info as $id => $data) {
                if (isset($data['delete']) && $data['delete'] == 1) {
                    DB::table('thongtinthanhtoan')->where('id', $id)->delete();
                } else {
                    DB::table('thongtinthanhtoan')->where('id', $id)->update([
                        'ten_nganhang' => $data['bank_name'] ?? '',
                        'ma_nganhang' => $data['bank_code'] ?? '',
                        'so_taikhoan' => $data['account_number'] ?? '',
                        'ten_chutaikhoan' => $data['account_name'] ?? '',
                        'chi_nhanh' => $data['branch'] ?? '',
                    ]);
                }
            }
        }

        // Add new bank info
        if ($request->has('new_bank') && !empty($request->new_bank['bank_name'])) {
            DB::table('thongtinthanhtoan')->insert([
                'pttt_id' => $request->new_bank['pttt_id'] ?? 2,
                'ten_nganhang' => $request->new_bank['bank_name'],
                'ma_nganhang' => $request->new_bank['bank_code'] ?? '',
                'so_taikhoan' => $request->new_bank['account_number'] ?? '',
                'ten_chutaikhoan' => $request->new_bank['account_name'] ?? '',
                'chi_nhanh' => $request->new_bank['branch'] ?? '',
                'noi_dung_mau' => 'Thanh toán đơn hàng #ORDER_ID',
            ]);
        }

        return back()->with('success', 'Cập nhật thông tin ngân hàng thành công!');
    }

    public function updateShipping(Request $request)
    {
        $errors = [];
        
        // Update existing shipping methods
        if ($request->has('shipping_methods')) {
            foreach ($request->shipping_methods as $id => $data) {
                if (isset($data['delete']) && $data['delete'] == 1) {
                    // Check if shipping method is in use
                    $inUse = DB::table('hoadon')->where('ptvc_id', $id)->exists();
                    if ($inUse) {
                        $errors[] = 'Không thể xóa phương thức vận chuyển đang được sử dụng bởi đơn hàng.';
                    } else {
                        DB::table('phuongthucvanchuyen')->where('id', $id)->delete();
                    }
                } else {
                    DB::table('phuongthucvanchuyen')->where('id', $id)->update([
                        'ten_ptvc' => $data['name'] ?? '',
                        'gia_vanchuyen' => (float)($data['fee'] ?? 0),
                        'mota' => $data['description'] ?? '',
                        'trangthai' => isset($data['status']) ? 1 : 0,
                    ]);
                }
            }
        }

        // Add new shipping method
        if ($request->has('new_shipping') && !empty($request->new_shipping['name'])) {
            DB::table('phuongthucvanchuyen')->insert([
                'ten_ptvc' => $request->new_shipping['name'],
                'gia_vanchuyen' => (float)($request->new_shipping['fee'] ?? 0),
                'mota' => $request->new_shipping['description'] ?? '',
                'trangthai' => isset($request->new_shipping['status']) ? 1 : 0,
            ]);
        }

        if (!empty($errors)) {
            return back()->with('error', implode(' ', $errors));
        }

        return back()->with('success', 'Cập nhật phương thức vận chuyển thành công!');
    }
}
