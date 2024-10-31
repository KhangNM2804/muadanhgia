<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimitBuy extends Model
{
    use HasFactory;

    protected $table = "limit_buy";
    protected $fillable = [
        'user_id', 'category_id', 'buyed_quantity', 'buy_expire_at'
    ];
}
