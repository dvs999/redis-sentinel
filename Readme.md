## Laravel Redis Sentinel

Allows to connect to Redis via Redis Sentinel

Change your redis config in config/database.php

```php
    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'password' => env('REDIS_PASSWORD', null),
            'database' => env('REDIS_DB', '0'),
            'master' => 'mymaster',
            'sentinel' => [
                'hosts' => [
                    '172.21.0.1' => 26379,
                ],
                'timeout' => 0,
                'persistent' => null,
                'retry_interval' => 0,
                'read_timeout' => 0,
            ],
        ],
    ],
```