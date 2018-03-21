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
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
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

    /** @var EntityManager */
    protected $entityManager;

    /**
     * PackageRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Package::class);
        $this->entityManager = $this->getEntityManager();
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
     * @throws ORMException
     */
    public function insertNewPackagesId(array $packagesId)
    {
        foreach ($packagesId as $packageId) {
            $package = new Package($packageId);
            $this->entityManager->persist($package);
        }

        $this->entityManager->flush();
    }

    /**
     * @param \ArrayObject|Package[] $entities
     * @throws ORMException
     */
    public function update(\ArrayObject $entities)
    {
        foreach ($entities as $entity) {
            $this->entityManager->merge($entity);
        }

        $this->entityManager->flush();
    }
}
