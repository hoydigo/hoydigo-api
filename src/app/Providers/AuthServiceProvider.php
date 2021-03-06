<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Laravel\Passport\Token;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(1));
        Passport::refreshTokensExpireIn(now()->addDays(1));
        Passport::personalAccessTokensExpireIn(now()->addDays(1));

        Passport::tokensCan([
            'auth:register' => 'Register new users',

            'admin:political-party:list' => 'List all political parties',
            'admin:political-party:create' => 'Create a new political party',
            'admin:political-party:get' => 'Get a specific political party',
            'admin:political-party:update' => 'Update a specific political party',
            'admin:political-party:delete' => 'Delete a specific political party',

            'admin:position:list' => 'List all available positions',
            'admin:position:create' => 'Create a new position',
            'admin:position:get' => 'Get a specific position',
            'admin:position:update' => 'Update a specific position',
            'admin:position:delete' => 'Delete a specific position',

            'admin:influencer:list' => 'List all available influencers',
            'admin:influencer:create' => 'Create a new influencer',
            'admin:influencer:get' => 'Get a specific influencer',
            'admin:influencer:update' => 'Update a specific influencer',
            'admin:influencer:delete' => 'Delete a specific influencer',
        ]);

        Passport::setDefaultScope([]);
    }
}
