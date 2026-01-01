<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = 'gioithieu';

    protected $fillable = [
        'tieude',
        'noidung',
        'hinhanh',
        'thutu',
        'trangthai',
        'ngaytao',
        'ngaycapnhat',
    ];

    protected $casts = [
        'thutu' => 'integer',
        'ngaytao' => 'datetime',
        'ngaycapnhat' => 'datetime',
    ];

    /**
     * Scope a query to only include visible about sections.
     */
    public function scopeVisible($query)
    {
        return $query->where('trangthai', 'Hiện');
    }

    /**
     * Scope a query to order by thutu.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('thutu')->orderBy('id');
    }
}

