<?php


namespace App\Classes\Twitter;


use App\Exceptions\TwitterClientCouldNotGetUserByUsernameException;
use Illuminate\Support\Facades\Http;

class TwitterClient
{
    /**
     * endpoint in the Twitter API to ge user data by username
     */
    const USER_BY_USERNAME_ENDPOINT = 'https://api.twitter.com/2/users/by/username/:username';

    /**
     * Endpoint to pull twits by Twitter user_id
     */
    const TWITS_BY_TWITTER_USER_ID_ENDPOINT = 'https://api.twitter.com/2/users/:user_id/tweets';

    /**
     * Bearer token to connect with Twitter API
     *
     * @var string
     */
    protected $token;

    /**
     * TwitterClient constructor.
     *
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get user data in Twitter by username
     *
     * @param string $username
     *
     * @return TwitterUserEntity
     *
     * @throws TwitterClientCouldNotGetUserByUsernameException
     */
    public function getUserByUsername(string $username): TwitterUserEntity
    {
        try {
            $fields = [
                'description',
                'id',
                'location',
                'name',
                'profile_image_url',
                'url',
                'username',
                'verified',
            ];

            $response = Http::withToken($this->token)
                ->get(
                    str_replace(":username", $username, self::USER_BY_USERNAME_ENDPOINT),
                    ['user.fields' => implode(',', $fields)]
                );

            return new TwitterUserEntity($response);

        } catch (\Throwable $e) {
            throw new TwitterClientCouldNotGetUserByUsernameException($e->getMessage());
        }
    }

    /**
     * Pull twits by user
     *
     * @param string $user_id
     *
     * @return array
     *
     * @throws TwitterClientCouldNotGetUserByUsernameException
     */
    public function getTwitsByUserId (string $user_id): array
    {
        try {
            $fields = [
                'max_results' => 100,
                'expansions' => 'attachments.poll_ids,attachments.media_keys,author_id,geo.place_id,in_reply_to_user_id,referenced_tweets.id,entities.mentions.username,referenced_tweets.id.author_id',
                'tweet.fields' => 'attachments,author_id,context_annotations,conversation_id,created_at,entities,geo,id,in_reply_to_user_id,lang,possibly_sensitive,public_metrics,referenced_tweets,reply_settings,source,text,withheld',
                'user.fields' => 'created_at,description,entities,id,location,name,pinned_tweet_id,profile_image_url,protected,public_metrics,url,username,verified,withheld',
                'media.fields' => 'duration_ms,height,media_key,non_public_metrics,organic_metrics,preview_image_url,promoted_metrics,public_metrics,type,url,width',
                'place.fields' => 'contained_within,country,country_code,full_name,geo,id,name,place_type',
                'poll.fields' => 'duration_minutes,end_datetime,id,options,voting_status',
            ];

            $response = Http::withToken($this->token)
                ->get(
                    str_replace(":user_id", $user_id, self::TWITS_BY_TWITTER_USER_ID_ENDPOINT),
                    $fields
                );

            $twits = json_decode($response->body())->data;

            return $twits;

        } catch (\Throwable $e) {
            throw new TwitterClientCouldNotGetUserByUsernameException($e->getMessage());
        }
    }

}
