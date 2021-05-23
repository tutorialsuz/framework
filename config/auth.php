<?php

use App\Models\User;

return [

    'guards' => [
        'web' => [
            'provider' => 'users'
        ]
    ],

    'providers' => [
        'users' => User::class
    ]

];