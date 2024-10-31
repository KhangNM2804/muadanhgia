<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categorys";
    protected $fillable = [
        'name', 'desc', 'price', 'type', 'display','sort_num', 'min_can_buy', 'long_desc', 'is_api', 'connect_api_id', 'origin_api_id', 'origin_price', 'quantity_remain'
    ];

    public static function getListByType($type, $name = ''){
        return self::where('type', $type)
                    ->where('display',1)
                    ->when($name, function ($query) use ($name) {
                        $query->where('name', 'LIKE','%'.$name.'%');
                    })
                    ->orderby('sort_num','asc')
                    ->orderby('id','asc')
                    ->get();
    }

    public function sell()
    {
        return $this->hasMany(ListSell::class,'type','id');
    }

    public function gettype()
    {
        return $this->hasOne(Type::class,'id','type');
    }

    public function connect_api()
    {
        return $this->hasOne(ConnectAPI::class,'id','connect_api_id');
    }
}