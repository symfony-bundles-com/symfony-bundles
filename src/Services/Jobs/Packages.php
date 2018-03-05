<?php
/**
 * This file is part of the Symfony-Bundles.com project
 * https://github.com/wow-apps/symfony-bundles
 *
 * (c) 2017 WoW-Apps
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Services\Jobs;

/**
 * Class Packages
 *
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-bundles
 */
class Packages implements JobInterface
{
    const JOB_NAME = 'packages';

    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getJobName(): string
    {
        return self::JOB_NAME;
    }

    /**
     * @return void
     */
    public function execute()
    {
        // TODO: Implement execute() method.
    }
}
