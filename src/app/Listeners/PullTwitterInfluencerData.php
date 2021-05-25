<?php

namespace App\Listeners;

use App\Classes\Twitter\TwitterClient;
use App\Events\InfluencerCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Config;

class PullTwitterInfluencerData implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The connection the job should be sent to.
     *
     * @var string
     */
    public $connection = 'database';

    /**
     * The queue the job should be sent to.
     *
     * @var string
     */
    public $queue = 'listeners';

    /**
     * Handle the event.
     *
     * @param  InfluencerCreated  $event
     * @return void
     */
    public function handle(InfluencerCreated $event)
    {
        $twitter_client = new TwitterClient(Config::get('twitter.bearer_token'));

        $twitter_user = $twitter_client->getUserByUsername($event->influencer->twitter_username);

        $event->influencer->refresh();
        $event->influencer->image = $twitter_user->getImageUrl();
        $event->influencer->twitter_id = $twitter_user->getId();
        $event->influencer->twitter_description = $twitter_user->getDescription();
        $event->influencer->twitter_url = $twitter_user->getUrl();
        $event->influencer->twitter_verified = $twitter_user->getVerified();
        $event->influencer->status = Config::get('influencer.status.active');
        $event->influencer->save();
    }
}
