<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueStatistic extends Model
{
    use HasFactory;

    protected $table = 'thongke_doanhthu';

    protected $fillable = [
        'ngay',
        'so_donhang',
        'doanh_thu',
    ];

    protected $casts = [
        'ngay' => 'date',
        'so_donhang' => 'integer',
        'doanh_thu' => 'decimal:2',
    ];
}

