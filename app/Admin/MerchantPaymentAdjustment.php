<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class MerchantPaymentAdjustment extends Model
{
    protected $table = 'm_pay_adjustments';


    protected $guarded = ['id'];
}
