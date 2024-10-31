<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = "tickets";
    protected $fillable = [
        'user_id', 'buy_id','priority', 'title', 'content', 'status', 'ip_address'
    ];

    public function getuser(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function comments(){
        return $this->hasMany(Ticket_Comment::class, 'ticket_id', 'id');
    }
}
