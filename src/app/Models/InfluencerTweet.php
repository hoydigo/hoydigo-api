<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencerTweet extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'influencer_twitter_id',
        'tweet_id',
        'conversation_id',
        'retweeted',
        'published_at'
    ];
}
