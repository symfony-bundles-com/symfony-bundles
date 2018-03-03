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

namespace App\Repository;

use App\Entity\Package;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class PackageRepository
 *
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package symfony-bundles-com/symfony-bundles
 */
class PackageRepository extends ServiceEntityRepository
{
    const TABLE_NAME = 'sb_packages';

    /**
     * PackageRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Package::class);
    }

    /**
     * @return array
     */
    public function getExistsPackagesIds(): array
    {
        $qbResult = $this
            ->createQueryBuilder('p')
            ->select('p.packageId')
            ->orderBy('p.packageId', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;

        return array_column($qbResult, 'packageId');
    }

    /**
     * @param array $packagesId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insertNewPackagesId(array $packagesId)
    {
        $em = $this->getEntityManager();

        $packagesIdChunks = array_chunk($packagesId, 100);

        foreach ($packagesIdChunks as $chunk) {
            foreach ($chunk as $packageId) {
                $package = new Package($packageId);
                $package->setAddedAt(new \DateTime(date('Y-m-d H:i:s')));
                $em->persist($package);
            }

            $em->flush();
        }
    }
}
