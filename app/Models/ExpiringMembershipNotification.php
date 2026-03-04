<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpiringMembershipNotification extends Model
{
    protected $fillable = [
        'member_id',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}