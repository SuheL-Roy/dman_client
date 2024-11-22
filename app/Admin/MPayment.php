<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class MPayment extends Model
{
    
    protected $table = 'm_payments';


      public function details()
         {
             return $this->belongsTo('App\Admin\MerchantPaymentDetail', 'invoice_id', 'invoice_id');
         } 


}
