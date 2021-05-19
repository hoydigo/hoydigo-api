<?php

namespace App\Listeners;

use App\Events\InfluencerCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PullTwitterInfluencerData
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  InfluencerCreated  $event
     * @return void
     */
    public function handle(InfluencerCreated $event)
    {
        echo $event->influencer->twitter_username;
    }
}
