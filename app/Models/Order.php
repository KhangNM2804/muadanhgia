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
    protected $appends = ['status_label'];
    public function type()
    {
        return $this->belongsTo(TypeOrder::class, 'type_order_id');
    }


    public function getStatusLabelAttribute()
    {
        $statusMap = [
            self::STATUS_PENDING => '<span class="badge badge-warning">Chờ duyệt</span>',
            self::STATUS_PROCESSING => '<span class="badge badge-info">Đang xử lý</span>',
            self::STATUS_CANCELLED => '<span class="badge badge-danger">Đã huỷ</span>',
            self::STATUS_REFUNDED => '<span class="badge badge-primary">Đã hoàn tiền</span>',
            self::STATUS_COMPLETED => '<span class="badge badge-success">Đã hoàn thành</span>',
        ];

        return $statusMap[$this->status] ?? '<span class="badge badge-secondary">Không rõ</span>';
    }
}
