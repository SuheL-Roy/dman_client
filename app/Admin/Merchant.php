<?php

namespace App\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $table = 'merchants';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * Get the user that owns the phone.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    /**
     * Get the user that owns the phone.
     */
    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    /**
     * Get the user that owns the phone.
     */
    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }
}
