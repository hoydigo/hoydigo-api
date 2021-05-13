<?php


namespace Tests\Feature\Http\Controllers\api\v1;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TestApi extends TestCase
{
    /**
     * Get api token
     *
     * @return string
     */
    protected function getToken(): string
    {
        $response = $this->json('post', '/api/v1/auth/get_token', [
            'email' => 'hoydigo.com@gmail.com',
            'password' => 'qwerty123',
        ]);

        print_r($response); die;

        $response_content = json_decode($response->getContent());

        return $response_content->access_token;
    }

    /**
     * Initialize migration
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
        Artisan::call('passport:install');
    }

}
