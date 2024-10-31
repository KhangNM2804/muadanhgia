<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket_Comment extends Model
{
    use HasFactory;

    protected $table = "ticket_comment";
    protected $fillable = [
        'user_id', 'ticket_id','content','ip_address'
    ];

    public function getuser(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
