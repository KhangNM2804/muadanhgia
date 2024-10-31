<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListSelled extends Model
{
    use HasFactory;
    protected $table = "list_selled";
    protected $fillable = [
        'buy_id', 'uid', 'full_info', 'type'
    ];
}
