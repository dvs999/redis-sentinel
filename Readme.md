## Laravel Redis Sentinel

Allows to connect to Redis via Redis Sentinel

Change your redis config in config/database.php

```php
      'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
        ],

        'default' => [
            'password' => env('REDIS_AUTH', ''),
            'database' => env('REDIS_DB', 0),
            'sentinel' => [
                'hosts' => explode(',', env('REDIS_SENTINEL_HOSTS')),
                'timeout' => '0.5',
                'master' => env('REDIS_SENTINEL_MASTER_NAME', 'mymaster'),

                'read_timeout' => (float)env('REDIS_SENTINEL_READ_TIMEOUT', '0'),
                'retry_interval' => (int)env('REDIS_SENTINEL_RETRY_INTERVAL', '0'),
                'persistent' => env('REDIS_SENTINEL_PERSIST', null),
            ],
            'serializer' => 'igbinary'
        ],
```
