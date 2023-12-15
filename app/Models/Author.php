<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'author_contact_no',
        'author_country',
        'created_at',
        'updated_at'
    ];
}
