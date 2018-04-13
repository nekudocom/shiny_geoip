<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Action\Cli;

class BenchmarkAction extends CliAction
{
    /**
     * Executes a benchmark.
     *
     * @param array $arguments
     */
    public function __invoke(array $arguments)
    {
        $this->responder->out('benchmark...');
    }
}
