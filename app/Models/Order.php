<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
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

    ];
}
