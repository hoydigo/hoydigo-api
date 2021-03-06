<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Roles and scopes
    |--------------------------------------------------------------------------
    |
    | Here you may configure the scopes by role.
    | This data is set in this config file, but It would be possible
    | manage it from a different source as a data base, or getting the scope
    | direct from the user or token with a different way to do an introspection.
    |
    */

    'admin' => [
        'scopes' => [
            'auth:register',

            'admin:political-party:list',
            'admin:political-party:create',
            'admin:political-party:get',
            'admin:political-party:update',
            'admin:political-party:delete',

            'admin:position:list',
            'admin:position:create',
            'admin:position:get',
            'admin:position:update',
            'admin:position:delete',

            'admin:influencer:list',
            'admin:influencer:create',
            'admin:influencer:get',
            'admin:influencer:update',
            'admin:influencer:delete',
        ]
    ],

    'web-guest' => ['scopes' => []],

    'mobile-guest' => ['scopes' => []],

];
