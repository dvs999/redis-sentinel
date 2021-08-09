<?php


namespace Dpsarr\LaravelRedisSentinel;


use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Redis\Connectors\PhpRedisConnector;
use Illuminate\Support\Facades\Log;
use RedisException;

class PhpRedisSentinelConnector extends PhpRedisConnector
{
    /**
     * @throws RedisException
     */
    public function connect(array $config, array $options): PhpRedisConnection
    {
        if (!array_key_exists('sentinel', $config) || !is_array($config['sentinel'])) {
            return parent::connect($config, $options);
        }

        foreach ($config['sentinel']['hosts'] as $host) {
            [$host,$port] = explode(':',$host);
            $sentinel = new \RedisSentinel(
                $host,
                $port,
                $item['timeout'] ?? 0,
                $item['persistent'] ?? null,
                $item['retry_interval'] ?? 0,
                $item['read_timeout'] ?? 0
            );

            if (!$sentinel->ping()) {
                continue;
            }

            $master = $sentinel->master($config['master'] ?? 'mymaster');

            if (false === $master) {
                throw new \RuntimeException('Error detecting Redis master');
            }

            $newConfig = [
                'host'     => $master['ip'],
                'port'     => $master['port'],
                'url'      => $config['url'] ?? null,
                'password' => $config['password'] ?? null,
                'database' => $config['database'] ?? 0,
            ];

            return parent::connect($newConfig, $options);
        }

        throw new RedisException('Error connecting to Redis');
    }
}
