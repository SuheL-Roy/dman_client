<?php

namespace App;

use App\Admin\RiderPayment;
use App\Admin\Transfer;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [];
    protected $fillable = [
        'name', 'email', 'password', 'business_name', 'mobile', 'area', 'address',
        'b_type', 'role', 'shop', 'status'
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


    public function transfer()
    {
        return $this->belongsTo(Transfer::class, 'sender_id');
    }

    /**
     * Get the phone associated with the user.
     */
    public function rider()
    {
        return $this->hasOne(RiderPayment::class, 'user_id');
    }
    /**
     * Get the phone associated with the user.
     */
    public function createby()
    {
        return $this->hasOne(RiderPayment::class, 'created_by');
    }
}
