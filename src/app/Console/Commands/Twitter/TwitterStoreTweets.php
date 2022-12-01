<?php

namespace App\Console\Commands\Twitter;

use App\Models\Influencer;
use App\Models\InfluencerTweet;
use App\Models\OriginalTweet;
use App\Models\Tweet;
use Illuminate\Console\Command;

class TwitterStoreTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:store-tweets {total_tweets_by_influencer?} {influencer_username?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store the tweets into the right tables.';

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
     */
    public function handle()
    {
        $total_tweets_by_influencer = $this->argument('total_tweets_by_influencer');
        $influencer_username = $this->argument('influencer_username');

        if (!($total_tweets_by_influencer > 0)) {
            echo "You need indicate a number as total tweets by influencer for store or update.\r\n";
            return 0;
        }

        $influencer = Influencer::where('twitter_username', $influencer_username)->first();

        if (!empty($influencer_username) && !$influencer) {
            echo "The influencer with the specific username was not found.\r\n";
            return 0;
        }

        $original_tweets = new OriginalTweet();

        if ($influencer) {
            $original_tweets = $original_tweets->where('author_id', $influencer->twitter_id);
        }

        $original_tweets = $original_tweets->orderBy('conversation_id', 'desc')->limit($total_tweets_by_influencer)->get();

        foreach ($original_tweets as $original_tweet) {
            $tweet = json_decode($original_tweet->tweet);

            Tweet::updateOrCreate(
                [
                    'twitter_id' => $original_tweet->twitter_id,
                    'author_id'  => $original_tweet->original_author_id
                ],
                [
                    'twitter_id'        => $original_tweet->twitter_id,
                    'author_id'         => $original_tweet->original_author_id,
                    'author_username'   => $original_tweet->original_author_username,
                    'text'              => $tweet->text,
                    'source'            => $tweet->source,
                    'lang'              => $tweet->lang,
                ]
            );

            InfluencerTweet::updateOrCreate(
                [
                    'influencer_twitter_id' => $original_tweet->author_id,
                    'tweet_twitter_id'      => $original_tweet->twitter_id,
                    'conversation_id'       => $original_tweet->conversation_id,
                ],
                [
                    'influencer_twitter_id' => $original_tweet->author_id,
                    'tweet_twitter_id'      => $original_tweet->twitter_id,
                    'conversation_id'       => $original_tweet->conversation_id,
                    'retweeted'             => (bool)$original_tweet->retweeted,
                    'published_at'          => $tweet->created_at
                ]
            );

            $influencer_twitter_username = $original_tweet->original_author_username ?? ($influencer->twitter_username ?? '');

            echo "Tweet $original_tweet->id of the user @$influencer_twitter_username was saved successfully.\r\n";
        }

        return 0;
    }
}
