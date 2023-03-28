<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OriginalTweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'twitter_id',
        'conversation_id',
        'author_id',
        'author_username',
        'retweeted',
        'original_author_username',
        'original_author_id',
        'tweet'
    ];
}
