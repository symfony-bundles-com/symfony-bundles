<?php
/**
 * This file is part of the Symfony-Bundles.com project
 * https://github.com/symfony-bundles-com/symfony-bundles
 *
 * (c) 2017 WoW-Apps
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Services;

use App\Repository\PackageRepository;
use WowApps\PackagistBundle\Service\Packagist;

/**
 * Class PackagistApi
 *
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-bundles
 */
class PackagistApi
{
    /** @var Packagist */
    private $packagist;

    /** @var PackageRepository */
    private $packageRepository;

    /**
     * PackagistApi constructor.
     * @param Packagist $packagist
     * @param PackageRepository $packageRepository
     */
    public function __construct(Packagist $packagist, PackageRepository $packageRepository)
    {
        $this->packagist = $packagist;
        $this->packageRepository = $packageRepository;
    }

    public function indexPackagesJob()
    {
        $existsPackages = $this->packageRepository->getExistsPackagesIds();
        var_dump($existsPackages);die;
        $packagesList = $this->packagist->getPackageList(null, Packagist::PACKAGE_TYPE_SYMFONY);
        foreach ($packagesList as $item) {

        }
    }
}