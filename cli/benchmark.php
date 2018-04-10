<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Cli;

require_once __DIR__ . '/../src/bootstrap_cli.php';

use Nekudo\ShinyGeoip\Core\Cli\Cli;
use Nekudo\ShinyGeoip\Domain\LocationDomain;

class Bechmark extends Cli
{
    /**
     * Number of queries to execute during benchmark.
     */
    const DB_QUERIES_TO_RUN = 50000;

    /**
     * Executes the benchmark.
     */
    public function __invoke()
    {
        try {
            $this->error('test');
            exit;
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
}

$benchmark = new Bechmark($config);
$benchmark->__invoke();
