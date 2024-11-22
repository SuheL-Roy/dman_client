<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

use App\User;

class DeliveryAssign extends Model
{
    protected $table = 'delivery_assigns';


    public function rider_info()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


  
}
