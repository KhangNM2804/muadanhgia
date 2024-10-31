<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\AuthChecker\Models\HasLoginsAndDevices;
use Lab404\AuthChecker\Interfaces\HasLoginsAndDevicesInterface;

class User extends Authenticatable implements HasLoginsAndDevicesInterface
{
    use Notifiable, HasLoginsAndDevices;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
        'coin', 
        'email',
        'fail_login',
        'is_band',
        'phone',
        'password',
        'domain',
        'tele_chat_id',
        'verifycodetele',
        'aff_flg', 'master_user_id', 'last_ip', 'chietkhau' , 'secret_code', 'api_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getChild($user_id)
    {
        return self::where('master_user_id', $user_id)->get();
    }

    public function historybank(){
        return $this->hasMany(HistoryBank::class, 'user_id', 'id');
    }

    public function historybuy(){
        return $this->hasMany(HistoryBuy::class, 'user_id', 'id');
    }

    public function tickets(){
        return $this->hasMany(Ticket::class, 'user_id', 'id');
    }
}