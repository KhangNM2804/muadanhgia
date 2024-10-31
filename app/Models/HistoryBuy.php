<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryBuy extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "history_buy";
    protected $fillable = [
        'user_id', 'quantity', 'price', 'total_price','type', 'is_api', 'connect_api_id', 'price_api', 'price_actual', 'profit'
    ];

    public function gettype(){
        return $this->hasOne(Category::class, 'id', 'type');
    }
    public function getuser(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getSelled(){
        return $this->hasMany(ListSelled::class, 'buy_id', 'id');
    }

}