<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class PickUpRequestAssign extends Model
{
    protected $table = 'pick_up_request_assigns';

    protected $dates = ['pickup_date'];
}
