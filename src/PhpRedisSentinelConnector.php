<?php


namespace Dpsarr\LaravelRedisSentinel;


use Illuminate\Redis\Connectors\PhpRedisConnector;

class PhpRedisSentinelConnector extends PhpRedisConnector
{
    public function connect(array $config, array $options)
    {
        if (!array_key_exists('sentinel', $config)) {
            throw new \InvalidArgumentException('Redis Sentinel config was not found');
        }

        $sentinel = new \RedisSentinel(
            $config['sentinel']['host'],
            $config['sentinel']['port'],
            $config['sentinel']['timeout'] ?? 0,
            $config['sentinel']['persistent'] ?? null,
            $config['sentinel']['retry_interval'] ?? 0,
            $config['sentinel']['read_timeout'] ?? 0
        );

        $master = $sentinel->master($config['master'] ?? 'mymaster');

        if (false === $master) {
            throw new \RuntimeException('Error detecting Redis master');
        }

        $newConfig = [
            'host'     => $master['id'],
            'port'     => $master['port'],
            'url'      => $config['url'],
            'password' => $config['password'],
            'database' => $config['database'],
        ];

        return parent::connect($newConfig, $options);
    }
}