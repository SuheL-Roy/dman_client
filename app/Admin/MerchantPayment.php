<?php

namespace App\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchantPayment extends Model
{
    protected $table = 'm_payments';

    protected $guarded = ['id'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function update_data(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'm_user_id');
    }
}
