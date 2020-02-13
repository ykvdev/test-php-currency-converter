<?php declare(strict_types=1);

return [
    'services' => [
        'guzzle' => [
            'http_errors' => false,
            'user_agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.132 Safari/537.36',
        ],

        'console_io' => [
            'logs_path' => __DIR__ . '/../../data/logs/console_{cmd}.log',
        ],

        'view_renderer' => [
            'path' => __DIR__ . '/../views',
            'extension' => 'phtml',
        ],

        'rates_db' => [
            'file' => __DIR__ . '/../../public/rates.json',
        ],

        'whoops' => [
            'editor' => 'phpstorm',
        ],

        'fast_route' => [
            'cache_file' => __DIR__ . '/../../data/fast_route.cache',

            'routes' => [
                ['GET', '/', \app\controllers\IndexController::class, 'index'],
            ],
        ],
    ],
];