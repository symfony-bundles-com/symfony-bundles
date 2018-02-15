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

namespace App\Services\Jobs;

/**
 * Interface JobInteface
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-bundles
 */
interface JobInteface
{
    /**
     * @return string
     */
    public function getJobName(): string;

    /**
     * @return void
     */
    public function runJob();
}
