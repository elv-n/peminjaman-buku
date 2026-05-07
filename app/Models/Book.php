<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'isbn',
        'stock',
        'cover',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
