<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip;

use Nekudo\ShinyGeoip\Action\Cli\BenchmarkAction;
use Nekudo\ShinyGeoip\Action\Cli\ShowHelpAction;
use Nekudo\ShinyGeoip\Action\Cli\UpdateMmdbAction;
use Nekudo\ShinyGeoip\Responder\CliResponder;

class ShinyGeoipCli
{
    /**
     * @var array $config
     */
    protected $config = [];

    /**
     * @var CliResponder $responder
     */
    protected $responder;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->responder = new CliResponder;
    }

    /**
     * Executes actions in cli mode based on given arguments.
     *
     * @param array $arguments Arguments from cli
     */
    public function dispatch(array $arguments)
    {
        try {
            $this->checkForCliMode();
            $actionName = $this->getAction($arguments);
            switch ($actionName) {
                case 'mmdb_update':
                    $action = new UpdateMmdbAction($this->config, $this->responder);
                    break;
                case 'benchmark':
                    $action = new BenchmarkAction($this->config, $this->responder);
                    break;
                case 'help':
                    $action = new ShowHelpAction($this->config, $this->responder);
                    break;
                default:
                    throw new \RuntimeException('Invalid action. Use "help" for list of available actions.');
            }

            $action->__invoke($arguments);
        } catch (\Exception $e) {
            $this->responder->error($e->getMessage());
        }
    }

    /**
     * Checks if script is executed in cli mode.
     *
     * @throws \RuntimeException
     */
    private function checkForCliMode()
    {
        if (php_sapi_name() !== 'cli') {
            throw new \RuntimeException('This script can only be executed in CLI mode.');
        }
    }

    /**
     * Fetches action from list of arguments.
     *
     * @param array $arguments
     * @return string
     */
    private function getAction(array $arguments): string
    {
        return $arguments[1] ?? '';
    }
}
