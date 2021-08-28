<?php

namespace App;

use App\Handlers\HandlerInterface;

final class Bot
{
    const VERSION = '1.0.0';

    /**
     * @var \App\Handlers\HandlerInterface[]
     */
    private $handlers;

    /**
     * @var int
     */
    private $sleep_time = 5;

    /**
     * @codeCoverageIgnore
     */
    public function launch(): void
    {
        while (true) {
            foreach ($this->handlers as $handler) {
                $this->processHandler($handler);
            }

            sleep($this->sleep_time);
        }
    }

    /**
     * @param \App\Handlers\HandlerInterface $handler
     * @codeCoverageIgnore
     */
    protected function processHandler(HandlerInterface $handler): void
    {
        try {
            $handler->launchHandler();
        } catch (\Exception $e) {
            // TODO add logger
            print_r($e->getMessage(), $e->getTraceAsString());
        }
    }

    /**
     * @param \App\Handlers\HandlerInterface[] $handlers
     * @codeCoverageIgnore
     */
    public function setHandlers(array $handlers): void
    {
        $this->handlers = $handlers;
    }
}