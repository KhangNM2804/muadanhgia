<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $table = "types";
    protected $fillable = [
        'name', 'display','sort_num', 'icon', 'is_api', 'connect_api_id', 'origin_api_id'
    ];

    public function allCategory(){
        return $this->hasMany(Category::class,'type','id')->where('display',1)->orderby('sort_num','asc')->orderby('id','asc');
    }
}