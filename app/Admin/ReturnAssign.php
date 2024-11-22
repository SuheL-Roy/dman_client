<?php

namespace App\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ReturnAssign extends Model
{
    protected $table = 'return_assigns';

    /**
     * Get the user that owns the phone.
     */
    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
    }

    /**
     * Get the user that owns the phone.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'create_by');
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

    // /**
    //  * Get the user that owns the phone.
    //  */
    // public function collect()
    // {
    //     return $this->belongsTo(RiderPaymentDetail::class, 'updated_by');
    // }
}
