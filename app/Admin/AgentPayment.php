<?php

namespace App\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentPayment extends Model
{
    protected $table = 'agent_payments';

    protected $guarded = ['id'];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
    public function createby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updateby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user that owns the phone.
     */
    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
    }
}
