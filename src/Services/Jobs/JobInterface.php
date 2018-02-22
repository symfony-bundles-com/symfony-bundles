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
 * Interface JobInterface
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-bundles
 */
interface JobInterface
{
    /**
     * Method, that returns job name
     * @return string
     */
    public function getJobName(): string;

    /**
     * Method, that runs a job
     * @return void
     */
    public function run();
}
