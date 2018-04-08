<?php
require_once __DIR__ . '/../src/bootstrap.php';

$reader = new \MaxMind\Db\Reader(__DIR__ . '/../data/GeoLite2-City.mmdb');
$redis = new \Redis;
$redis->connect('/run/redis/redis.sock');
$redis->select(0);

$count = 50000;
$startTime = microtime(true);
for ($i = 0; $i < $count; $i++) {
    $ip = long2ip(rand(0, pow(2, 32) -1));
    try {
        $t = $reader->get($ip);
        if (!isset($t['city'])) {
            continue;
        }
        $key = $t['city']['geoname_id'];
        $geonameData = $redis->get($key);
        if (empty($geonameData)) {
            continue;
        }
        $geonameData = json_decode($geonameData, true);
    } catch (Exception $e) {
    }
    if ($i % 1000 == 0) {
        print($i . ' ' . $ip . "\n");
    }
}
$endTime = microtime(true);
$duration = $endTime - $startTime;
$redis->close();
print('Requests per second: ' . $count / $duration . "\n");
