<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'tintuc';

    protected $fillable = [
        'tieude',
        'noidung',
        'tomtat',
        'hinhanh',
        'ngaydang',
        'ngaycapnhat',
        'tacgia',
        'luotxem',
        'trangthai',
        'noibat',
    ];

    protected $casts = [
        'luotxem' => 'integer',
        'ngaydang' => 'datetime',
        'ngaycapnhat' => 'datetime',
    ];

    /**
     * Scope a query to only include published news.
     */
    public function scopePublished($query)
    {
        return $query->where('trangthai', 'Công khai');
    }

    /**
     * Increment view count.
     */
    public function incrementViews()
    {
        $this->increment('luotxem');
    }
}

