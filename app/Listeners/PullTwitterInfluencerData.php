<?php

namespace App\Listeners;

use App\Classes\Twitter\TwitterClient;
use App\Events\InfluencerTwitterDataRequested;
use App\Exceptions\TwitterClientCouldNotGetUserByUsernameException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

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
     * @param  InfluencerTwitterDataRequested  $event
     * @return void
     */
    public function handle(InfluencerTwitterDataRequested $event)
    {
        try {
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

            Log::info('influencer: ' . $event->influencer->twitter_username . ', message: Activated successfully.');

        } catch (TwitterClientCouldNotGetUserByUsernameException $e) {
            Log::error(
                'influencer: ' . $event->influencer->twitter_username . ', ' .
                'message: Error trying to get user data from twitter.' . ', ' .
                'error: ' . $e->getMessage()
            );

        } catch (\Throwable $e) {
            Log::error(
                'influencer: ' . $event->influencer->twitter_username . ', ' .
                'error: ' . $e->getMessage()
            );

        }
    }
}
