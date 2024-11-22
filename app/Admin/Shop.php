<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shops';

    protected $guarded = ['id'];
}
