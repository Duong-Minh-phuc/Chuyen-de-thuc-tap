<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OrderDetail;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'order';
    
    // Status Constants
    const STATUS_PROCESSING = 1;    // Đang xử lý
    const STATUS_CONFIRMED = 2;     // Đã xác nhận
    const STATUS_DELIVERING = 4;    // Đang giao hàng
    const STATUS_DELIVERED = 5;     // Đã giao hàng
    const STATUS_CANCELLED = 7;     // Đã hủy

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'note',
        'status'
    ];

    // Status Labels
    public static function getStatusLabels()
    {
        return [
            self::STATUS_PROCESSING => 'Đang xử lý',
            self::STATUS_CONFIRMED => 'Đã xác nhận',
            self::STATUS_DELIVERING => 'Đang giao hàng',
            self::STATUS_DELIVERED => 'Đã giao hàng',
            self::STATUS_CANCELLED => 'Đã hủy'
        ];
    }

    // Status Colors for Tailwind CSS
    public static function getStatusColors()
    {
        return [
            self::STATUS_PROCESSING => 'text-yellow-800 bg-yellow-100',
            self::STATUS_CONFIRMED => 'text-blue-800 bg-blue-100',
            self::STATUS_DELIVERING => 'text-indigo-800 bg-indigo-100',
            self::STATUS_DELIVERED => 'text-green-800 bg-green-100',
            self::STATUS_CANCELLED => 'text-red-800 bg-red-100'
        ];
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        return self::getStatusLabels()[$this->status] ?? 'Không xác định';
    }

    // Get status color
    public function getStatusColorAttribute()
    {
        return self::getStatusColors()[$this->status] ?? 'text-gray-800 bg-gray-100';
    }

    // Valid status transitions
    public static function getValidStatusTransitions()
    {
        return [
            self::STATUS_PROCESSING => [self::STATUS_CONFIRMED, self::STATUS_CANCELLED],
            self::STATUS_CONFIRMED => [self::STATUS_DELIVERING, self::STATUS_CANCELLED],
            self::STATUS_DELIVERING => [self::STATUS_DELIVERED, self::STATUS_CANCELLED],
            self::STATUS_DELIVERED => [], // Không thể chuyển từ trạng thái đã giao
            self::STATUS_CANCELLED => []  // Không thể chuyển từ trạng thái đã hủy
        ];
    }

    // Check if status transition is valid
    public function canTransitionTo($newStatus)
    {
        $validTransitions = self::getValidStatusTransitions()[$this->status] ?? [];
        return in_array($newStatus, $validTransitions);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
