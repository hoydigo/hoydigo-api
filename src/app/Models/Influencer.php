<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'political_position_id',
        'political_party_id',
        'name',
        'image',
        'twitter_id',
        'twitter_username',
        'twitter_description',
        'twitter_url',
        'twitter_verified'
    ];

    /**
     * Positions that the influencer has
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function positions()
    {
        return $this->belongsToMany(Position::class, 'influencer_position', 'influencer_id', 'position_id');
    }
}
