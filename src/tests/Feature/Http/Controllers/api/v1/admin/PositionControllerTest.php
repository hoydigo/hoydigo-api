<?php


namespace Tests\Feature\Http\Controllers\api\v1\admin;

use App\Models\Position;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Tests\Feature\Http\Controllers\api\v1\TestApi;

/**
 * Class PoliticalPartyControllerTest
 *
 * Run these specific tests
 * php artisan test tests/Feature/Http/Controllers/api/v1/admin/PositionControllerTest.php
 *
 * @package Tests\Unit\Controllers\api\v1\admin
 */
class PositionControllerTest extends TestApi
{
    /**
     * Political position api endpoint
     */
    const ENDPOINT_ADMIN_POSITION = '/api/v1/admin/position';

    /**
     * Returns array with a position mock data
     *
     * @return array
     */
    public function getPositionMockData(): array
    {
        return [
            'id'          => Str::random(6),
            'country_id'  => 'COL',
            'state_id'    => 5,
            'city_id'     => 1017,
            'sector'      => Str::random(10),
            'name'        => Str::random(10),
            'description' => Str::random(50),
        ];
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_list_positions(): void
    {
        Position::truncate();

        $mock_positions = [
            $this->getPositionMockData(),
            $this->getPositionMockData(),
            $this->getPositionMockData(),
        ];

        foreach ($mock_positions as $position_data) {
            Position::create($position_data);
        }

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT_ADMIN_POSITION);

        $response->assertStatus(200);
        $response->assertJsonCount(3, ['data']);
        $response->assertSee($mock_positions[0]['id']);
        $response->assertSee($mock_positions[1]['name']);
        $response->assertSee($mock_positions[2]['description']);
        $response->assertJsonPath('data.0.country.name', 'Colombia');
        $response->assertJsonPath('data.0.state.id', 5);
        $response->assertJsonPath('data.0.city.id', 1017);
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
    public function user_get_exception_trying_to_list_positions(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\Position');
        $client_mock->shouldReceive('orderBy')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\Position', $client_mock);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT_ADMIN_POSITION);

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_store_a_new_position(): void
    {
        Position::truncate();

        $mock_position = $this->getPositionMockData();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('POST', self::ENDPOINT_ADMIN_POSITION, $mock_position);

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Position created successfully');
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function user_get_exception_trying_to_store_a_new_position(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\Position');
        $client_mock->shouldReceive('create')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\Position', $client_mock);

        $mock_position_data = $this->getPositionMockData();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('POST', self::ENDPOINT_ADMIN_POSITION, $mock_position_data);

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_get_a_specific_position(): void
    {
        Position::truncate();

        $mock_position_data = $this->getPositionMockData();
        Position::create($mock_position_data);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT_ADMIN_POSITION . '/' . $mock_position_data['id']);

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $mock_position_data['id']);
        $response->assertJsonPath('data.name', $mock_position_data['name']);
        $response->assertJsonPath('data.description', $mock_position_data['description']);
        $response->assertJsonPath('data.country.name', 'Colombia');
        $response->assertJsonPath('data.state.id', 5);
        $response->assertJsonPath('data.city.id', 1017);
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_try_to_get_a_position_that_does_not_exist(): void
    {
        Position::truncate();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT_ADMIN_POSITION . '/WRONID');

        $response->assertStatus(404);
        $response->assertJsonPath('message', 'Position not found');
    }

    /**
     * @test
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function user_get_exception_trying_to_get_a_position(): void
    {
        $client_mock = \Mockery::mock('overload:App\Models\Position');
        $client_mock->shouldReceive('find')->andThrow(new \Exception('Exception test'));
        App::instance('\App\Models\Position', $client_mock);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('GET', self::ENDPOINT_ADMIN_POSITION . '/WRONID');

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Exception test');
    }

}
