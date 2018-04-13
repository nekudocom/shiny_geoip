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
        $this->responder->out('help....');
    }
}
