<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectAPI extends Model
{
    use HasFactory;
    protected $table = "connect_api";
    protected $fillable = [
        'domain', 'api_key', 'auto_price', 'auto_change_name','active', 'balance', 'system', 'username', 'password'
    ];
}