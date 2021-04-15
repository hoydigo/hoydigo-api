<?php

namespace Tests\Unit\Controllers\api\v1;

use App\Http\Controllers\api\v1\AuthController;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\PersonalAccessTokenResult;
use Tests\TestCase;

/**
 * Class LoginController
 *
 * Run these specific tests
 * php artisan test tests/Unit/Controllers/api/v1/AuthControllerTest.php
 *
 * @package Tests\Unit\Controllers\api\v1
 */
class AuthControllerTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function successful_login(): void
    {
        Auth::shouldReceive('attempt')->once()->andReturn(1);

        $token_mock = $this->createMock(PersonalAccessTokenResult::class);
        $token_mock->accessToken = 'token_test';

        $user_mock = $this->createMock(User::class);
        $user_mock->name = 'user_test';
        $user_mock->email = 'user@test.com';
        $user_mock->method('createToken')->willReturn($token_mock);

        Auth::shouldReceive('user')->once()->andReturn($user_mock);

        $controller = new AuthController();
        $request = Request::create('/api/v1/user/get_token', 'POST',[
            'email'     => 'user@test.com',
            'password'  => 'test123'
        ]);

        $response =  $controller->getToken($request);

        $response_content = json_decode($response->getContent());
        $user_mock->removeTokens();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($user_mock->name, $response_content->name);
        $this->assertEquals($user_mock->email, $response_content->email);
        $this->assertEquals('token_test', $response_content->access_token);
    }

    /**
     * @test
     *
     * @return void
     */
    public function invalid_login_credentials(): void
    {
        Auth::shouldReceive('attempt')->once()->andReturn(0);

        $controller = new AuthController();
        $request = Request::create('/api/v1/user/get_token', 'POST',[
            'email'     => 'wrong@email.com',
            'password'  => 'test123'
        ]);

        $response =  $controller->getToken($request);

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('Invalid login credentials.', json_decode($response->getContent())->message);
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function user_registered_successfully(): void
    {
        $validator_mock = $this->createMock(Validator::class);
        $validator_mock->method('fails')->willReturn(false);
        \Illuminate\Support\Facades\Validator::shouldReceive('make')->once()->andReturn($validator_mock);

        $client_mock = \Mockery::mock('overload:App\Models\User');
        $client_mock->shouldReceive('create')->andReturn($client_mock);
        App::instance('\App\Models\User', $client_mock);

        $controller = new AuthController();
        $request = Request::create('/api/v1/user/register', 'POST',[
            'role'     => 'web-guest',
            'name'     => 'Unit Test 4',
            'email'    => 'unit4.test@email.com',
            'password' => 'test123'
        ]);

        $response =  $controller->register($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('User registered successfully', json_decode($response->getContent())->message);
    }
}
