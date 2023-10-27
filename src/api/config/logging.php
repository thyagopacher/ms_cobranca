<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [
    "default" => env("LOG_CHANNEL", "stack"),


    "deprecations" => [
        "channel" => env("LOG_DEPRECATIONS_CHANNEL", "null"),
        "trace" => false,
    ],

    "channels" => [
        "stack" => [
            "driver" => "stack",
            "channels" => ["stdout"],
            "path" => storage_path("logs/laravel.log"),
        ],
        'stdout' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stdout'
            ]
        ],
        "single" => [
            "driver" => "single",
            "path" => storage_path("logs/laravel.log"),
            "level" => env("LOG_LEVEL", "debug"),
        ],
        "daily" => [
            "driver" => "daily",
            "path" => storage_path("logs/laravel.log"),
            "level" => env("LOG_LEVEL", "debug"),
            "days" => 2,
        ],
    ],
];

