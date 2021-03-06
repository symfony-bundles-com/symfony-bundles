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

use Psr\Log\LoggerInterface;
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

    /** @var LoggerInterface */
    private $logger;

    /**
     * PackagistApi constructor.
     * @param Packagist $packagist
     * @param PackageRepository $packageRepository
     * @param LoggerInterface $logger
     */
    public function __construct(Packagist $packagist, PackageRepository $packageRepository, LoggerInterface $logger)
    {
        $this->packagist = $packagist;
        $this->packageRepository = $packageRepository;
        $this->logger = $logger;
    }

    /**
     * @return void
     */
    public function indexPackagesJob()
    {
        $this->logger->debug('Start getting exists packages id');
        $existsPackages = $this->packageRepository->getExistsPackagesIds();
        $this->logger->info(sprintf('Founded %d exists packages id', count($existsPackages)));

        $this->logger->debug(
            'Start getting exists packages from Packagist.org',
            ['vendor' => 'null', 'package_type' => Packagist::PACKAGE_TYPE_SYMFONY]
        );
        $packagesList = $this->packagist->getPackageList(null, Packagist::PACKAGE_TYPE_SYMFONY);
        $this->logger->info(
            sprintf('Founded %d packages on Packagist.org', count($existsPackages)),
            ['vendor' => 'null', 'package_type' => Packagist::PACKAGE_TYPE_SYMFONY]
        );

        foreach ($packagesList as $key => $packageId) {
            if (in_array($packageId, $existsPackages)) {
                $this->logger->debug(sprintf('Package %s already exists', $packageId));
                unset($packagesList[$key]);
            }
        }

        if (empty($packagesList)) {
            $this->logger->info('Not found a new packages');
            return;
        }

        $this->packageRepository->insertNewPackagesId($packagesList);
        $this->logger->info(sprintf('Added %d new packages', count($packagesList)));
    }
}
