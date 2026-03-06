<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardOfTrustee extends Model
{
    protected $fillable = [
        'image',
        'lastname',
        'firstname',
        'middlename',
        'gender',
        'board_position_id',
        'status'
    ];

    public function position()
    {
        return $this->belongsTo(BoardPosition::class,'board_position_id');
    }
}
