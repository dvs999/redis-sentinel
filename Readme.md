## Laravel Redis Sentinel

Allows to connect to Redis via Redis Sentinel

Change your redis config in config/database.php

```php
    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis_sentinel'),

        'sentinel' => [
            'hosts' => [
                'localhost' => 26379,
                'remote_host' => 'remote_port',
            ],
        ],

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

    ],
```