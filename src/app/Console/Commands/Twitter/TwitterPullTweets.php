<?php

namespace App\Console\Commands\Twitter;

use App\Classes\Twitter\TwitterClient;
use App\Exceptions\TwitterClientCouldNotGetUserByUsernameException;
use App\Models\Influencer;
use App\Models\OriginalTweet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class TwitterPullTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:pull-tweets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws TwitterClientCouldNotGetUserByUsernameException
     */
    public function handle()
    {
        $twitter_client = new TwitterClient(Config::get('twitter.bearer_token'));

        $influencers = Influencer::get();

        foreach ($influencers as $influencer) {
            if ($influencer->twitter_id) {
                echo "Pull Twits for @$influencer->twitter_username with twitter_id $influencer->twitter_id \r\n";

                $twits = $twitter_client->getTweetsByUserId($influencer->twitter_id);
                $this->storeTweets(!empty($twits) ? $twits : []);
            }
        }

        return 0;
    }

    /**
     * Store each tweet into the DB
     *
     * @param array $twits
     *
     * @return void
     */
    private function storeTweets(array $twits): void
    {
        foreach ($twits as $tweet) {

            try {
                $is_retweeted = (strpos($tweet->text, 'RT') === 0);
                $json_tweet = json_encode($tweet);

                OriginalTweet::updateOrCreate(
                    [
                        'id'        => $tweet->id,
                        'author_id' => $tweet->author_id
                    ],
                    [
                        'id'                        => $tweet->id,
                        'conversation_id'           => $tweet->conversation_id,
                        'author_id'                 => $tweet->author_id,
                        'retweeted'                 => $is_retweeted,
                        'original_author_username'  => $is_retweeted ? $tweet->entities->mentions[0]->username : null,
                        'original_author_id'        => $is_retweeted ? $tweet->entities->mentions[0]->id : null,
                        'tweet'                     => $json_tweet
                    ]
                );

                echo "Tweet $tweet->id with author_id $tweet->author_id was saved successfully.\r\n";

            } catch (\Throwable $e) {
                echo "Error. Tweet $tweet->id with author_id $tweet->author_id was not saved.\r\n";

                Log::error(
                    'Pull Tweets from twitter, ' .
                    "event: Error. Tweet $tweet->id with author_id $tweet->author_id was not saved., " .
                    'message: ' . $e->getMessage()
                );
            }

        }
    }

}
