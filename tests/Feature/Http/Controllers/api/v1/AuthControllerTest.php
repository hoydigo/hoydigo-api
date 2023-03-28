<?php

namespace Tests\Feature\Http\Controllers\api\v1;

/**
 * Class AuthControllerTest
 *
 * Run these specific tests
 * php artisan test tests/Feature/Http/Controllers/api/v1/AuthControllerTest.php
 *
 * @package Tests\Feature\Http\Controllers\api\v1
 */
class AuthControllerTest extends TestApi
{
    /**
     * Political party api endpoint
     */
    const ENDPOINT = '/api/v1/auth';

    /**
     * @test
     *
     * @return void
     */
    public function user_can_register_a_new_user()
    {
        $new_user_data = [
            'name' => 'Test Name',
            'email' => 'test@myadomain.com',
            'password' => '123456',
            'role' => 'web-guest',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('POST', self::ENDPOINT . '/register', $new_user_data);

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'User registered successfully');
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_not_register_a_user_with_no_valid_role()
    {
        $new_user_data = [
            'name' => 'Test Name',
            'email' => 'test@myadomain.com',
            'password' => '123456',
            'role' => 'wrong-role',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('POST', self::ENDPOINT . '/register', $new_user_data);

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['role']]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_not_register_a_user_with_an_email_on_use()
    {
        $new_user_data = [
            'name' => 'Test Name',
            'email' => 'hoydigo.com@gmail.com',
            'password' => '123456',
            'role' => 'web-guest',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('POST', self::ENDPOINT . '/register', $new_user_data);

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['email']]);
    }
}
