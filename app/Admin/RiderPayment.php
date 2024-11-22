<?php

namespace App\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class RiderPayment extends Model
{

    protected $guarded = ['id'];

    protected $table = 'rider_payments';

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
    public function create()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    /**
     * Get the user that owns the phone.
     */
    public function updateUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    /**
     * Get the user that owns the phone.
     */
    public function collect()
    {
        return $this->belongsTo(RiderPaymentDetail::class, 'updated_by');
    }
}
