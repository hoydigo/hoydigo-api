<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
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
}
