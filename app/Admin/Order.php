<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    protected $table = 'orders';

    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function merchant_info()
    {
        return $this->belongsTo('App\Admin\Merchant', 'user_id', 'user_id');
    }

    public function user_info()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function shop_info()
    {
        return $this->belongsTo('App\Admin\Shop', 'shop', 'shop_name');
    }

    public function zone_info()
    {
        return $this->belongsTo('App\Admin\CoverageArea', 'area', 'area');
    }
}
