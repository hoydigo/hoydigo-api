<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'twitter_id',
        'author_id',
        'author_username',
        'text',
        'source',
        'lang'
    ];
}
