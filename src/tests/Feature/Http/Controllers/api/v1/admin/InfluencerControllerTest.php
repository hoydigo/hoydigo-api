<?php


namespace Tests\Feature\Http\Controllers\api\v1\admin;

use App\Models\Influencer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Tests\Feature\Http\Controllers\api\v1\TestApi;

/**
 * Class InfluencerControllerTest
 *
 * Run these specific tests
 * php artisan test tests/Feature/Http/Controllers/api/v1/admin/InfluencerControllerTest.php
 *
 * @package Tests\Unit\Controllers\api\v1\admin
 */
class InfluencerControllerTest extends TestApi
{
    /**
     * influencer api endpoint
     */
    const ENDPOINT_ADMIN_INFLUENCER = '/api/v1/admin/influencer';

    /**
     * Returns array with a influencer mock data
     *
     * @return array
     */
    public function getInfluencerMockData(): array
    {
        return [
            'political_position_id' => 'CEN',
            'political_party_id'    => null,
            'name'                  => Str::random(10),
            'image'                 => null,
            'twitter_id'            => null,
            'twitter_username'      => Str::random(10),
            'twitter_description'   => null,
            'twitter_url'           => null,
            'twitter_verified'      => null,
        ];
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_store_a_new_influencer(): void
    {
        Influencer::truncate();

        $mock_influencer_data = $this->getInfluencerMockData();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('POST', self::ENDPOINT_ADMIN_INFLUENCER, $mock_influencer_data);

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Influencer ' . $mock_influencer_data['name'] . ' created successfully');
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function user_get_exception_trying_to_store_a_new_influencer(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\Influencer');
        $client_mock->shouldReceive('create')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\Influencer', $client_mock);

        $mock_influencer_data = $this->getInfluencerMockData();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('POST', self::ENDPOINT_ADMIN_INFLUENCER, $mock_influencer_data);

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
    }

}
