<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';

    // Role constants
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;
    const ROLE_STAFF = 2;

    // Staff permissions
    const STAFF_PERMISSIONS = [
        'dashboard.view',
        'product.view',
        'product.create',
        'product.update',
        'category.view',
        'category.create',
        'category.update',
        'order.view',
        'order.update_status',
        'comment.view',
        'comment.reply',
        'comment.hide',
        'topping.view',
        'topping.create',
        'topping.update',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hoten',
        'email',
        'sdt',
        'password',
        'avatar',
        'is_admin',
        'trangthai',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user's full name.
     */
    public function getNameAttribute()
    {
        return $this->hoten;
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->is_admin == self::ROLE_ADMIN;
    }

    /**
     * Check if user is staff.
     */
    public function isStaff()
    {
        return $this->is_admin == self::ROLE_STAFF;
    }

    /**
     * Check if user is admin or staff.
     */
    public function isAdminOrStaff()
    {
        return $this->isAdmin() || $this->isStaff();
    }

    /**
     * Check if user has a specific permission.
     * Admins have full access, staff have limited permissions.
     */
    public function hasPermission($permission)
    {
        // Admin has full access
        if ($this->isAdmin()) {
            return true;
        }

        // Staff has limited permissions
        if ($this->isStaff()) {
            return in_array($permission, self::STAFF_PERMISSIONS);
        }

        return false;
    }

    /**
     * Get role name for display.
     */
    public function getRoleName()
    {
        return match($this->is_admin) {
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_STAFF => 'Nhân viên',
            default => 'Khách hàng',
        };
    }

    /**
     * Get the cart items for the user.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Get the comments for the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
}

