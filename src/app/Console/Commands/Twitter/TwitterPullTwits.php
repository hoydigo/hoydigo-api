<?php

namespace App\Console\Commands\Twitter;

use App\Classes\Twitter\TwitterClient;
use App\Exceptions\TwitterClientCouldNotGetUserByUsernameException;
use App\Models\Influencer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class TwitterPullTwits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:pull-twits';

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
                echo "Pull Twits for $influencer->twitter_username with twitter_id $influencer->twitter_id \r\n";

                $twits = $twitter_client->getTwitsByUserId($influencer->twitter_id);
                $this->storeTwits(!empty($twits) ? $twits : []);
            }
        }

        echo "Pull Twits \r\n";
        return 0;
    }

    public function storeTwits(array $twits): void
    {
        foreach ($twits as $twit) {
            print_r($twit); die;
        }
    }
}
