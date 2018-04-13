<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Action\Cli;

use Nekudo\ShinyGeoip\Responder\CliResponder;

abstract class CliAction
{
    /**
     * @var array $config
     */
    protected $config;

    /**
     * @var CliResponder $responder
     */
    protected $responder;

    /**
     * CliAction constructor.
     *
     * @param array $config
     * @param CliResponder $responder
     */
    public function __construct(array $config, CliResponder $responder)
    {
        $this->config = $config;
        $this->responder = $responder;
    }

    /**
     * @param array $arguments
     * @return void
     */
    abstract public function __invoke(array $arguments);
}
