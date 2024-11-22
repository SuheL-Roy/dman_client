<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class MerchantAdvancePayment extends Model
{
    protected $table = 'merchant_advance_payments';

    protected $fillable = ['merchant_id', 'business', 'area', 'phone', 'amount', 'comment'];
}
