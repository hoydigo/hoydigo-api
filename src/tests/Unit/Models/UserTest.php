<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Laravel\Passport\Token;
use Tests\TestCase;

/**
 * Class UserTest
 *
 * Run these specific tests
 * php artisan test tests/Unit/Models/UserTest.php
 *
 * @package Tests\Unit\Models
 */
class UserTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function tokens_removed(): void
    {
        $user = \Mockery::mock(User::class)
            ->makePartial();

        $toke_mock = $this->createMock(Token::class);
        $user->tokens = [$toke_mock, $toke_mock];

        $user->removeTokens();

        $this->assertTrue(false);

    }

    /**
     * @test
     *
     * @return void
     */
    public function right_admin_scopes(): void
    {
        $user = \Mockery::mock(User::class)
            ->makePartial();
        $user->role = 'admin';
        $user->getScopes();
        $this->assertEquals(['user:register', 'test:get-users'], $user->getScopes());
    }

}
