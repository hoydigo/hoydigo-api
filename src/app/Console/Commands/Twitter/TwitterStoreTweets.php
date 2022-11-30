<?php

namespace App\Console\Commands\Twitter;

use App\Models\Influencer;
use Illuminate\Console\Command;

class TwitterStoreTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:pull-tweets {total_tweets_by_influencer?} {influencer_username?}';

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

        return 0;
    }
}
