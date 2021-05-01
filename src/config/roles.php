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
            'admin:political-party:create'
        ]
    ],

    'web-guest' => ['scopes' => []],

    'mobile-guest' => ['scopes' => []],

];
