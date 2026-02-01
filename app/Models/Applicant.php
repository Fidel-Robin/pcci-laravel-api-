<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $table = 'applicants';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'applicant_status'   
    ];  

    protected $attributes = [
        'applicant_status' => 'pending',
    ];
}
