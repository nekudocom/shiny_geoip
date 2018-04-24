<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Action\Cli;

use Nekudo\ShinyGeoip\Domain\LocationDomain;

class BenchmarkAction extends CliAction
{
    /**
     * @var int $numLookups
     */
    private $numLookups = 50000;

    /**
     * @var LocationDomain $domain
     */
    private $domain;

    /**
     * Executes a benchmark.
     *
     * @param array $arguments
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function __invoke(array $arguments)
    {
        $this->domain = new LocationDomain($this->config);
        $this->runBenchmark();
    }

    /**
     * Runs the actual benchmark by doing a bunch of IP lookups to the database.
     */
    private function runBenchmark()
    {
        $startTime = microtime(true);
        for ($i = 0; $i < $this->numLookups; $i++) {
            $ip = long2ip(rand(0, pow(2, 32) -1));
            try {
                $this->domain->getRecord($ip);
            } catch (\Exception $e) {
            }
            if ($i % 1000 == 0) {
                $this->responder->out($i . ' ' . $ip);
            }
        }
        $endTime = microtime(true);
        $duration = $endTime - $startTime;
        $this->responder->success('Requests per second: ' . $this->numLookups / $duration);
    }
}
