<?php


namespace App\Classes\Twitter;


use App\Exceptions\TwitterClientCouldNotGetUserByUsernameException;
use Illuminate\Support\Facades\Http;

class TwitterClient
{
    /**
     * endpoint in the twitter API to ge user data by username
     */
    const USER_BY_USERNAME_ENDPOINT = 'https://api.twitter.com/2/users/by/username/:username';

    /**
     * Bearer token to connect with twitter API
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
     * Get user data in twitter by user name
     *
     * @param string $username
     *
     * @return TwitterUserEntity
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

}
