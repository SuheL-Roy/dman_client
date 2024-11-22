<?php

namespace App\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    protected $table = 'order_status_histories';
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assign()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
