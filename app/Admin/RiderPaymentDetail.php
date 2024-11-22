<?php

namespace App\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class RiderPaymentDetail extends Model
{
    protected $guarded = ['id'];

    protected $table = 'rider_payment_details';



    /**
     * Get the user that owns the phone.
     */
    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
    }
}
