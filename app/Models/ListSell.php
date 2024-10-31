<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListSell extends Model
{
    use HasFactory;
    protected $table = "list_sell";
    protected $fillable = [
        'uid', 'full_info', 'type', 'die'
    ];

    public function category()
    {
        return $this->hasOne(Category::class,'id','type');
    }
}
