<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliticalParty extends Model
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
    protected $fillable = ['id', 'political_position_id', 'name', 'description'];

    /**
     * Political position fo the spacific political party
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function politicalPosition()
    {
        return $this->belongsTo(PoliticalPosition::class, 'political_position_id');
    }
}
