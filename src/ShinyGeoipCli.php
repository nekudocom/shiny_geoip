<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip;

use Nekudo\ShinyGeoip\Responder\CliResponder;

class ShinyGeoipCli
{
    /**
     * @var array $config
     */
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
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
            $action = $this->getAction($arguments);
            switch ($action) {
                case 'benchmark':
                    // @todo Call benchmark action...
                    break;
                case 'help':
                    // @todo Call help action...
                    break;
                default:
                    throw new \RuntimeException('Invalid action. Use "help" for list of available actions.');
            }
        } catch (\Exception $e) {
            $responder = new CliResponder;
            $responder->error($e->getMessage());
        }
    }

    /**
     * Checks if script is executed in cli mode.
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
