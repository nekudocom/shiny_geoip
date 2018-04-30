<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Action\Cli;

class ShowHelpAction extends CliAction
{
    /**
     * Displays CLI application help.
     *
     * @param array $arguments
     */
    public function __invoke(array $arguments)
    {
        $this->responder->out('ShinyGeoip CLI application');
        $this->responder->out('Usage: php cli/app.php [ACTION]');
        $this->responder->out('');
        $this->responder->out('The following actions are available:');
        $this->responder->out('');
        $this->responder->out("  benchmark\tRun a benchmark and puts..");
        $this->responder->out("  mmdb_update\tUpdates the mmdb database.");
        $this->responder->out("  help\t\tShows this help.");
        $this->responder->out('');
        $this->responder->out('Examples:');
        $this->responder->out('');
        $this->responder->out("  php cli/app.php benchmark\t Runs a benchmark.");
        $this->responder->out("  php cli/app.php mmdb_update\t Updates the mmdb database.");
    }
}
