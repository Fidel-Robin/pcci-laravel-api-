<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'photo_path',
        'status',
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
