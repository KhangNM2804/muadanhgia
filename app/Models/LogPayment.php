<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPayment extends Model
{
    use HasFactory;
    protected $table = "log_payments";
    public const STATUS_SUCCESS = 1;
    public const STATUS_ERROR = 2;
    protected $fillable = [
        'id',
        'user_id',
        'action',
        'message',
        'file',
        'before_coin',
        'after_coin',
        'status',
    ];
}
