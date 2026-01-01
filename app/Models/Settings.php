<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'quantri';

    protected $fillable = [
        'logo',
        'favicon',
        'website_info',
        'shop_info',
        'facebook',
        'twitter',
        'instagram',
        'zalo',
        'pinterest',
        'linkedin',
        'tiktok',
        'hotline',
        'email',
        'address',
    ];

    /**
     * Get the main settings instance.
     */
    public static function getMainSettings()
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'shop_info' => 'Food Shop',
                'website_info' => 'Chuyên cung cấp đồ ăn ngon, chất lượng',
            ]
        );
    }
}

