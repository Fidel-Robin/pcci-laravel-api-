<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipType extends Model
{
    use HasFactory;

    protected $table = 'membership_types';

    // Fillable fields for mass assignment
    protected $fillable = [
        'name',
        'price',
        'duration_in_months',
        'renewal_price',
        'notes',
    ];

    // Optional: cast fields to correct types
    protected $casts = [
        'price' => 'decimal:2',
        'renewal_price' => 'decimal:2',
        'duration_in_months' => 'integer',
    ];
}
