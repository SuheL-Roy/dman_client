<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Partial extends Model
{
    protected $guarded = ['id'];

    protected $table = 'partials';
}
