<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title',
        'body',
        'author_id'
    ];  

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id'); 
    }
}
