<?php

return [
    'services' => [
        'guzzle' => [
            'http_errors' => false,
            'user_agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.132 Safari/537.36',
        ],

        'console_io' => [
            'logs_path' => __DIR__ . '/../../data/logs/console-{cmd}.log',
        ],

        'view_renderer' => [
            'path' => __DIR__ . '/../views',
            'extension' => 'phtml',
        ],

        'whoops' => [
            'editor' => 'phpstorm',
        ],

        'rates_api' => [
            'available_symbols' => ['USD', 'RUB', 'EUR'],
            'file_db' => __DIR__ . '/../../public/data/rates.json',
        ],

        'fast_route' => [
            'cache_file' => __DIR__ . '/../../data/fast_route.cache',

            'routes' => [
                ['GET', '/', \app\controllers\IndexController::class, 'index'],
            ],
        ],
    ],
];