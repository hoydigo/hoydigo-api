<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    /**
     * Indicates key doesn't increment
     *
     * For this model the key is string
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'country_id', 'state_id', 'city_id', 'sector', 'name', 'description'];

    /**
     * Country where the position is
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * State where the position is
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * City where the position is
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }


    /**
     * Positions that the influencer has
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function influencers()
    {
        return $this->belongsToMany(Influencer::class, 'influencer_position', 'position_id', 'influencer_id');
    }
}
