<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAction extends Model
{
    use HasFactory;
    protected $table = "log_actions";
    protected $fillable = [
        'id',
        'user_id',
        'action',
        'message',
        'file',
    ];
}
