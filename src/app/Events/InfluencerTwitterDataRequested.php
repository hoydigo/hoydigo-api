<?php

namespace App\Events;

use App\Models\Influencer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InfluencerTwitterDataRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Influencer
     */
    public $influencer;

    /**
     * Create a new event instance.
     *
     * @param Influencer $influencer
     *
     * @return void
     */
    public function __construct(Influencer $influencer)
    {
        $this->influencer = $influencer;
    }
}
