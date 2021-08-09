<?php


namespace Dpsarr\LaravelRedisSentinel;


use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;

class RedisServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Redis::extend('phpredis', function () {
            return new PhpRedisSentinelConnector();
        });
    }
}
