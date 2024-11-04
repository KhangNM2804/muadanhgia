<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOrder extends Model
{
    use HasFactory;
    protected $table = "type_orders";
    protected $fillable = [
        'id',
        'name',
        'price',
        'description',
        'created_at',
        'updated_at',
        'path',
    ];
}
