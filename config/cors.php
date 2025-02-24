<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', '*'], // Allow all API routes
    'allowed_methods' => ['*'], // Allow all HTTP methods (GET, POST, PUT, DELETE, etc.)
    'allowed_origins' => ['*'], // Allow all origins (or specify frontend URL)
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Allow all headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false, // Set to true if using authentication
];
