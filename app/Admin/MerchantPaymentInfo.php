<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class MerchantPaymentInfo extends Model
{
    protected $guarded = ['id'];


    protected $table = 'm_payment_infos';
}
