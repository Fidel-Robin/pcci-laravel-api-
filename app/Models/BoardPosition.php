<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardPosition extends Model
{
    protected $fillable = [
        'position'
    ];

    public function trustees()
    {
        return $this->hasMany(BoardOfTrustee::class);
    }
}
