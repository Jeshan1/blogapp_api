<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Allow API routes

    'allowed_methods' => ['*'], // Allow all methods (GET, POST, etc.)

    'allowed_origins' => ['*'], // Allow requests from the frontend

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Allow all headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // If you need to send credentials (cookies, headers)
];

