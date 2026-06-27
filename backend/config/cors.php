<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'https://todjom.greenlyfes.com',
        'http://localhost:3000' // Utile pour vos tests en local
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Indispensable si vous utilisez l'authentification par cookies/session (Sanctum)
];