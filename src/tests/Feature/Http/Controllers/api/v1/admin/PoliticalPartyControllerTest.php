<?php


namespace Tests\Feature\Http\Controllers\api\v1\admin;

use App\Models\PoliticalParty;
use Illuminate\Support\Str;
use Tests\Feature\Http\Controllers\api\v1\ApiTest;

/**
 * Class PoliticalPartyControllerTest
 *
 * Run these specific tests
 * php artisan test tests/Feature/Http/Controllers/api/v1/admin/PoliticalPartyControllerTest.php
 *
 * @package Tests\Unit\Controllers\api\v1\admin
 */
class PoliticalPartyControllerTest extends ApiTest
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

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())->json('GET', self::ENDPOINT);

        $response->assertStatus(200);
        $response->assertJsonCount(3, ['data']);
        $response->assertSee($mock_political_parties[0]['id']);
        $response->assertSee($mock_political_parties[1]['political_position_id']);
        $response->assertSee($mock_political_parties[2]['name']);
        $response->assertJsonCount(4, ['links']);
    }
}
