<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'user_id',
        'membership_type_id',
        'induction_date',
        'membership_end_date',
        'status',
    ];

    protected $casts = [
        'induction_date' => 'date',
        'membership_end_date' => 'date',
    ];

    // Relationships
    public function applicant()
    {
        return $this->belongsTo(\App\Models\Applicant::class, 'applicant_id', 'id');
    }

    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
