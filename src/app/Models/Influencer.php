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
        'country_id',
        'political_position_id',
        'political_party_id',
        'name',
        'image',
        'twitter_id',
        'twitter_username',
        'twitter_description',
        'twitter_url',
        'twitter_verified',
        'status',
    ];

    /**
     * Country where the influencer is
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Political position for the influencer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function political_position()
    {
        return $this->belongsTo(PoliticalPosition::class, 'political_position_id');
    }

    /**
     * Political party for the influencer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function political_party()
    {
        return $this->belongsTo(PoliticalParty::class, 'political_party_id');
    }

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
