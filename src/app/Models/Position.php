<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

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
