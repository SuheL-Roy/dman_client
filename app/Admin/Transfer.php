<?php

namespace App\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'transfers';

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function media()
    {
        return $this->belongsTo(User::class, 'media_id');
    }
}
