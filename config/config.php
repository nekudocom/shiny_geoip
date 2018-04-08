<?php

declare(strict_types=1);

return [

    // Path to MaxMind GeoIP database:
    'mmdb_path' => __DIR__ . '/../data/GeoLite2-City.mmdb',

    // Path to GeoNames database:
    'geonames_path' => __DIR__ . '/../data/cities1000.txt',

    // Redis Config
    'redis_enabled' => true, // set to false if you do not want to use redis
    'redis_connection_type' => 'socket', // can be "socket" or "tcp"
    'redis_socket' => '/run/redis/redis.sock',
    'redis_host' => '127.0.0.1',
    'redis_port' => 6379,
    'redis_db' => 0,
];
