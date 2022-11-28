<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OriginalTweet extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'conversation_id',
        'author_id',
        'retweeted',
        'original_author_username',
        'original_author_id',
        'tweet'
    ];
}
