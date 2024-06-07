<?php

namespace Psr\Log;

/**
 * This is a simple Logger implementation that other Loggers can inherit from.
 *
 * It simply delegates all log-level-specific methods to the `log` method to
 * reduce boilerplate code that a simple Logger that does the same thing with
 * messages regardless of the error level has to implement.
 */
abstract class AbstractLogger implements LoggerInterface
{
    use LoggerTrait;

    /**
     * Logs with an arbitrary level.
     *
     * @param string $level The logging level
     * @param mixed $message The log message
     * @param array $context The log context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        // Implement your logging logic here
        // This is just a placeholder, you can customize it based on your requirements
        echo sprintf("[%s] %s: %s\n", $level, date('Y-m-d H:i:s'), $message);
    }
}