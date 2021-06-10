<?php


namespace Dpsarr\LaravelRedisSentinel;


use Illuminate\Redis\Connectors\PhpRedisConnector;
use RedisException;

class PhpRedisSentinelConnector extends PhpRedisConnector
{
    /**
     * @throws RedisException
     */
    public function connect(array $config, array $options)
    {
        if (!array_key_exists('sentinel', $config) || !is_array($config['sentinel'])) {
            throw new \InvalidArgumentException('Redis Sentinel config was not found');
        }

        foreach ($config['sentinel'] as $item) {
            $sentinel = new \RedisSentinel(
                $item['host'],
                $item['port'],
                $item['timeout'] ?? 0,
                $item['persistent'] ?? null,
                $item['retry_interval'] ?? 0,
                $item['read_timeout'] ?? 0
            );

            if ($sentinel !== null) {
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

        throw new RedisException('Error connecting to Redis');
    }
}