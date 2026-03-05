<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'category_id',
        'date',
        'time',
        'location',
        'description',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
