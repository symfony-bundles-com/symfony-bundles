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
 * Class IndexPackages
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-bundles
 */
class IndexPackages implements JobInteface
{
    const JOB_NAME = 'index_packages';

    public function __construct()
    {
        //
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
    public function runJob()
    {
        // TODO: Implement runJob() method.
    }
}
