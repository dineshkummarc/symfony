<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bridge\Propel1\Logger;

use Symfony\Component\HttpKernel\Debug\Stopwatch;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

/**
 * PropelLogger.
 *
 * @author Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author William Durand <william.durand1@gmail.com>
 */
class PropelLogger
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var array
     */
    protected $queries;

    /**
     * @var \Symfony\Component\HttpKernel\Debug\Stopwatch
     */
    protected $stopwatch;

    private $isPrepare;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger A LoggerInterface instance
     * @param Stopwatch       $stopwatch A Stopwatch instance
     */
    public function __construct(LoggerInterface $logger = null, Stopwatch $stopwatch = null)
    {
        $this->logger    = $logger;
        $this->queries   = array();
        $this->stopwatch = $stopwatch;
        $this->isPrepare = true;
    }

    /**
     * A convenience function for logging an alert event.
     *
     * @param mixed $message the message to log.
     */
    public function alert($message)
    {
        if (null !== $this->logger) {
            $this->logger->alert($message);
        }
    }

    /**
     * A convenience function for logging a critical event.
     *
     * @param mixed $message the message to log.
     */
    public function crit($message)
    {
        if (null !== $this->logger) {
            $this->logger->crit($message);
        }
    }

    /**
     * A convenience function for logging an error event.
     *
     * @param mixed $message the message to log.
     */
    public function err($message)
    {
        if (null !== $this->logger) {
            $this->logger->err($message);
        }
    }

    /**
     * A convenience function for logging a warning event.
     *
     * @param mixed $message the message to log.
     */
    public function warning($message)
    {
        if (null !== $this->logger) {
            $this->logger->warn($message);
        }
    }

    /**
     * A convenience function for logging an critical event.
     *
     * @param mixed $message the message to log.
     */
    public function notice($message)
    {
        if (null !== $this->logger) {
            $this->logger->notice($message);
        }
    }

    /**
     * A convenience function for logging an critical event.
     *
     * @param mixed $message the message to log.
     */
    public function info($message)
    {
        if (null !== $this->logger) {
            $this->logger->info($message);
        }
    }

    /**
     * A convenience function for logging a debug event.
     *
     * @param mixed $message the message to log.
     */
    public function debug($message)
    {
        $add = true;

        if (null !== $this->stopwatch) {
            if ($this->isPrepare) {
                $this->stopwatch->start('propel', 'propel');
                $this->isPrepare = false;

                $add = false;
            } else {
                $this->stopwatch->stop('propel');
                $this->isPrepare = true;
            }
        }

        if ($add) {
            $this->queries[] = $message;
            if (null !== $this->logger) {
                $this->logger->debug($message);
            }
        }
    }

    /**
     * Returns queries.
     *
     * @return array    Queries
     */
    public function getQueries()
    {
        return $this->queries;
    }
}
