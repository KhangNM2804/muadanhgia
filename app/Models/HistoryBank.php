<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryBank extends Model
{
    use HasFactory;
    protected $table = "history_bank";
    protected $fillable = [
        'user_id', 'trans_id', 'coin', 'memo','type', 'admin_id'
    ];

    public function getuser(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getadmin(){
        return $this->hasOne(User::class, 'id', 'admin_id');
    }

}
