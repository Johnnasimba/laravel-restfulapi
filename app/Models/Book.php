<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_title',
        'book_isbn',
        'book_price',
        'book_publish_year',
        'author_id',
        'created_at',
        'updated_at'
    ];
}
