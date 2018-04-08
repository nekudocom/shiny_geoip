<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Cli;

use Nekudo\ShinyGeoip\Domain\LocationDomain;

class Bechmark
{
    /**
     * Number of queries to execute during benchmark.
     */
    const DB_QUERIES_TO_RUN = 50000;

    /**
     * @var array $config
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Executes the benchmark.
     */
    public function __invoke()
    {
        try {
            $domain = new LocationDomain($this->config);
            $this->runBechmark($domain);
        } catch (\Exception $e) {
            print_r('Error: ' . $e->getMessage());
        }
    }

    /**
     * Queries the database DB_QUERIES_TO_RUN times and calculates avg. requests per second.
     *
     * @param LocationDomain $domain
     */
    private function runBechmark(LocationDomain $domain)
    {
        $maxQueries = self::DB_QUERIES_TO_RUN;
        $startTime = microtime(true);
        for ($i = 0; $i < $maxQueries; $i++) {
            $ip = long2ip(rand(0, pow(2, 32) -1));
            try {
                $domain->getRecord($ip);
            } catch (\Exception $e) {
            }
            if ($i % 1000 == 0) {
                $this->out($i . ' ' . $ip);
            }
        }
        $endTime = microtime(true);
        $duration = $endTime - $startTime;
        $this->out('Requests per second: ' . $maxQueries / $duration);
    }

    /**
     * Echos out a message to stdout.
     *
     * @param string $message
     */
    private function out(string $message)
    {
        echo $message . PHP_EOL;
    }
}

require_once __DIR__ . '/../src/bootstrap.php';
$benchmark = new Bechmark($config);
$benchmark->__invoke();
