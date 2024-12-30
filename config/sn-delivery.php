<?php

// config for Wsmallnews/Delivery
return [

    /*
     * Model name for user.
     */
    'user_model' => class_exists(\App\Models\User::class) ? \App\Models\User::class : null,

    'deliverys' => [
        'express' => [
            'driver' => 'express',
            '',
        ],
    ],
];
