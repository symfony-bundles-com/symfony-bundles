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

namespace App\Exception;

use Psr\Log\InvalidArgumentException;

/**
 * Class JobException
 *
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-bundles
 */
class JobException extends InvalidArgumentException
{
    const E_UNKNOWN_JOB = 'Unknown job called. Choose one of next: %s';
}
