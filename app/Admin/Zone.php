<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zones';


    public function district_info()
    {
        return $this->belongsTo('App\Admin\District', 'district_id', 'id');
    }
}
