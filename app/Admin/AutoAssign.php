<?php

namespace App\Admin;

use App\User;

use Illuminate\Database\Eloquent\Model;

class AutoAssign extends Model
{
    protected $table = 'auto_assigns';

    public function user_rider()
    {
        return $this->belongsTo(User::class, 'riderid');
    }

   
    public function user_merchant()
    {
        return $this->belongsTo(User::class, 'merchantid');
    }


 
 
}
