<?php
/**
 * This file is part of the Symfony-Bundles.com project
 * https://github.com/symfony-bundles-com/symfony-bundles
 *
 *  (c) 2018 WoW-Apps
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Services;

use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * Class JobLogger
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-bundles
 */
class JobLogger
{
    const LOG_LEVEL_DEBUG     = 1;
    const LOG_LEVEL_INFO      = 2;
    const LOG_LEVEL_NOTICE    = 3;
    const LOG_LEVEL_WARNING   = 4;
    const LOG_LEVEL_ERROR     = 5;
    const LOG_LEVEL_CRITICAL  = 6;
    const LOG_LEVEL_ALERT     = 7;
    const LOG_LEVEL_EMERGENCY = 8;

    /** @var LoggerInterface */
    private $logger;

    /**
     * JobLogger constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param int $logLevel
     * @param string $logMessage
     * @param bool $saveToDb
     * @throws InvalidArgumentException
     */
    public function log(int $logLevel, string $logMessage, bool $saveToDb = true)
    {
        if (!$this->checkLogLevel($logLevel)) {
            throw new InvalidArgumentException('Invalid log level');
        }


    }

    /**
     * @param int $logLevel
     * @return bool
     */
    private function checkLogLevel(int $logLevel): bool
    {
        if ($logLevel < self::LOG_LEVEL_DEBUG || $logLevel > self::LOG_LEVEL_EMERGENCY) {
            return false;
        }

        return true;
    }
}
