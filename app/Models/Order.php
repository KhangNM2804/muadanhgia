<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    public const STATUS_PENDING = 1;        // Chờ duyệt
    public const STATUS_PROCESSING = 2;     // Đang xử lý
    public const STATUS_CANCELLED = 3;      // Đã huỷ
    public const STATUS_REFUNDED = 4;       // Đã hoàn tiền
    public const STATUS_COMPLETED = 5;      // Đã hoàn thành
    protected $fillable = [
        'id',
        'user_id',
        'type_order_id',
        'code',
        'link',
        'total_money',
        'total_quantity',
        'quantity_run',
        'content',
        'note',
        'images',
        'price',
        'status'
    ];
    protected $attributes = [
        'status' => self::STATUS_PENDING,
    ];
}
