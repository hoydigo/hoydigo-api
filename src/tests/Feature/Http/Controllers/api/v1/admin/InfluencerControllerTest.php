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
            'country_id'            => 'COL',
            'political_position_id' => 'CEN',
            'political_party_id'    => null,
            'name'                  => Str::random(10),
            'twitter_username'      => Str::random(10),
            'status'                => 'PENDING',
        ];
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_list_influencers(): void
    {
        Influencer::truncate();

        $mock_influencers = [
            $this->getInfluencerMockData(),
            $this->getInfluencerMockData(),
            $this->getInfluencerMockData(),
        ];

        foreach ($mock_influencers as $influencer_data) {
            Influencer::create($influencer_data);
        }

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT_ADMIN_INFLUENCER);

        $response->assertStatus(200);
        $response->assertJsonCount(3, ['data']);
        $response->assertSee($mock_influencers[1]['name']);
        $response->assertSee($mock_influencers[2]['twitter_username']);
        $response->assertJsonPath('data.0.country.name', 'Colombia');
        $response->assertJsonPath('data.0.political_position.name', 'Centro');
        $response->assertJsonCount(4, ['links']);
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function user_get_exception_trying_to_list_influencers(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\Influencer');
        $client_mock->shouldReceive('orderBy')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\Influencer', $client_mock);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT_ADMIN_INFLUENCER);

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
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

    /**
     * @test
     *
     * @return void
     */
    public function user_get_a_specific_influencer(): void
    {
        Influencer::truncate();

        $mock_influencer_data = $this->getInfluencerMockData();
        Influencer::create($mock_influencer_data);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT_ADMIN_INFLUENCER . '/1');

        $response->assertStatus(200);
        $response->assertJsonPath('data.name', $mock_influencer_data['name']);
        $response->assertJsonPath('data.country.name', 'Colombia');
        $response->assertJsonPath('data.political_position.name', 'Centro');
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_try_to_get_an_influencer_that_does_not_exist(): void
    {
        Influencer::truncate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT_ADMIN_INFLUENCER . '/-1');

        $response->assertStatus(404);
        $response->assertJsonPath('message', 'Influencer not found');
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function user_get_exception_trying_to_get_an_influencer(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\Influencer');
        $client_mock->shouldReceive('find')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\Influencer', $client_mock);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT_ADMIN_INFLUENCER . '/1');

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_update_a_specific_influencer(): void
    {
        Influencer::truncate();

        $mock_influencer_data = $this->getInfluencerMockData();
        $mock_influencer_data_updated = $this->getInfluencerMockData();
        unset($mock_influencer_data_updated['political_party_id']);

        Influencer::create($mock_influencer_data);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('PATCH', self::ENDPOINT_ADMIN_INFLUENCER . '/1', $mock_influencer_data_updated);

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', 1);
        $response->assertJsonPath('data.name', $mock_influencer_data_updated['name']);
        $response->assertJsonPath('data.twitter_username', $mock_influencer_data_updated['twitter_username']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_try_to_update_an_influencer_that_does_not_exist(): void
    {
        Influencer::truncate();
        $mock_influencer_data_updated = $this->getInfluencerMockData();
        unset($mock_influencer_data_updated['political_party_id']);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('PATCH', self::ENDPOINT_ADMIN_INFLUENCER . '/-1', $mock_influencer_data_updated);

        $response->assertStatus(404);
        $response->assertJsonPath('message', 'Influencer not found');
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function user_get_exception_trying_to_update_an_influencer(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\Influencer');
        $client_mock->shouldReceive('find')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\Influencer', $client_mock);

        $mock_influencer_data_updated = $this->getInfluencerMockData();
        unset($mock_influencer_data_updated['political_party_id']);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('PATCH', self::ENDPOINT_ADMIN_INFLUENCER . '/-1', $mock_influencer_data_updated);

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_delete_a_specific_influencer(): void
    {
        Influencer::truncate();
        $token = $this->getToken();

        $mock_influencer_data = $this->getInfluencerMockData();
        Influencer::create($mock_influencer_data);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('DELETE', self::ENDPOINT_ADMIN_INFLUENCER . '/1');

        $response->assertStatus(204);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('DELETE', self::ENDPOINT_ADMIN_INFLUENCER . '/1');

        $response->assertStatus(404);
        $response->assertJsonPath('message', 'Influencer not found');
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function user_get_exception_trying_to_delete_an_influencer(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\Influencer');
        $client_mock->shouldReceive('find')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\Influencer', $client_mock);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('DELETE', self::ENDPOINT_ADMIN_INFLUENCER . '/1');

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
    }

}
