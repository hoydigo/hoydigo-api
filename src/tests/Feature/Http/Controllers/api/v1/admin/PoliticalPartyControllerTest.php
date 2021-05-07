<?php


namespace Tests\Feature\Http\Controllers\api\v1\admin;

use App\Models\PoliticalParty;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Tests\Feature\Http\Controllers\api\v1\TestApi;

/**
 * Class PoliticalPartyControllerTest
 *
 * Run these specific tests
 * php artisan test tests/Feature/Http/Controllers/api/v1/admin/PoliticalPartyControllerTest.php
 *
 * @package Tests\Unit\Controllers\api\v1\admin
 */
class PoliticalPartyControllerTest extends TestApi
{
    /**
     * Political party api endpoint
     */
    const ENDPOINT = '/api/v1/admin/political-party';

    /**
     * Returns array with a political party mock data
     *
     * @return array
     */
    public function getPoliticalPartyMockData(): array
    {
        $political_positions = ['DEX', 'DER', 'DCE', 'CEN', 'ICE', 'IZQ', 'IEX'];

        return [
            'id'                    => Str::random(5),
            'political_position_id' => $political_positions[array_rand($political_positions)],
            'name'                  => Str::random(10),
            'description'           => Str::random(30),
        ];
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_list_political_parties(): void
    {
        PoliticalParty::truncate();

        $mock_political_parties = [
            $this->getPoliticalPartyMockData(),
            $this->getPoliticalPartyMockData(),
            $this->getPoliticalPartyMockData(),
        ];

        foreach ($mock_political_parties as $political_party_data) {
            PoliticalParty::create($political_party_data);
        }

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT);

        $response->assertStatus(200);
        $response->assertJsonCount(3, ['data']);
        $response->assertSee($mock_political_parties[0]['id']);
        $response->assertSee($mock_political_parties[1]['political_position_id']);
        $response->assertSee($mock_political_parties[2]['name']);
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
    public function user_get_exception_trying_to_list_political_parties(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\PoliticalParty');
        $client_mock->shouldReceive('orderBy')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\PoliticalParty', $client_mock);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT);

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_store_a_new_political_party(): void
    {
        PoliticalParty::truncate();

        $mock_political_party_data = $this->getPoliticalPartyMockData();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('POST', self::ENDPOINT, $mock_political_party_data);

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $mock_political_party_data['id']);
        $response->assertJsonPath('data.political_position_id', $mock_political_party_data['political_position_id']);
        $response->assertJsonPath('data.name', $mock_political_party_data['name']);
        $response->assertJsonPath('data.description', $mock_political_party_data['description']);
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function user_get_exception_trying_to_store_a_new_political_party(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\PoliticalParty');
        $client_mock->shouldReceive('create')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\PoliticalParty', $client_mock);

        $mock_political_party_data = $this->getPoliticalPartyMockData();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('POST', self::ENDPOINT, $mock_political_party_data);

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_get_a_specific_political_party(): void
    {
        PoliticalParty::truncate();

        $mock_political_party_data = $this->getPoliticalPartyMockData();
        PoliticalParty::create($mock_political_party_data);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT . '/' . $mock_political_party_data['id']);

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $mock_political_party_data['id']);
        $response->assertJsonPath('data.political_position.id', $mock_political_party_data['political_position_id']);
        $response->assertJsonPath('data.name', $mock_political_party_data['name']);
        $response->assertJsonPath('data.description', $mock_political_party_data['description']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_try_to_get_a_political_party_that_does_not_exist(): void
    {
        PoliticalParty::truncate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT . '/WROID');

        $response->assertStatus(404);
        $response->assertJsonPath('message', 'Political party not found');
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function user_get_exception_trying_to_get_a_political_party(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\PoliticalParty');
        $client_mock->shouldReceive('find')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\PoliticalParty', $client_mock);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT . '/WROID');

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_update_a_specific_political_party(): void
    {
        PoliticalParty::truncate();

        $mock_political_party_data = $this->getPoliticalPartyMockData();
        $mock_political_party_data_updated = $this->getPoliticalPartyMockData();
        unset($mock_political_party_data_updated['id']);

        PoliticalParty::create($mock_political_party_data);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('PATCH', self::ENDPOINT . '/' . $mock_political_party_data['id'], $mock_political_party_data_updated);

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $mock_political_party_data['id']);
        $response->assertJsonPath('data.political_position.id', $mock_political_party_data_updated['political_position_id']);
        $response->assertJsonPath('data.name', $mock_political_party_data_updated['name']);
        $response->assertJsonPath('data.description', $mock_political_party_data_updated['description']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_try_to_update_a_political_party_that_does_not_exist(): void
    {
        PoliticalParty::truncate();
        $mock_political_party_data_updated = $this->getPoliticalPartyMockData();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('PATCH', self::ENDPOINT . '/WROID', $mock_political_party_data_updated);

        $response->assertStatus(404);
        $response->assertJsonPath('message', 'Political party not found');
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function user_get_exception_trying_to_update_a_political_party(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\PoliticalParty');
        $client_mock->shouldReceive('find')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\PoliticalParty', $client_mock);

        $mock_political_party_data_updated = $this->getPoliticalPartyMockData();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('PATCH', self::ENDPOINT . '/WROID', $mock_political_party_data_updated);

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_delete_a_specific_political_party(): void
    {
        PoliticalParty::truncate();
        $token = $this->getToken();

        $mock_political_party_data = $this->getPoliticalPartyMockData();
        $mock_political_party_data_updated = $this->getPoliticalPartyMockData();
        unset($mock_political_party_data_updated['id']);

        PoliticalParty::create($mock_political_party_data);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('DELETE', self::ENDPOINT . '/' . $mock_political_party_data['id']);

        $response->assertStatus(204);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('DELETE', self::ENDPOINT . '/' . $mock_political_party_data['id']);

        $response->assertStatus(404);
        $response->assertJsonPath('message', 'Political party not found');
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function user_get_exception_trying_to_delete_a_political_party(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\PoliticalParty');
        $client_mock->shouldReceive('find')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\PoliticalParty', $client_mock);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('DELETE', self::ENDPOINT . '/ANYID');

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
    }
}
