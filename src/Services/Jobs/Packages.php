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

use App\Entity\Package;
use App\Traits\TextHelperTrait;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;
use App\Repository\PackageRepository;
use WowApps\PackagistBundle\DTO\Package as PackageDTO;
use WowApps\PackagistBundle\Service\ApiProvider;
use WowApps\PackagistBundle\Service\Packagist;

/**
 * Class Packages
 *
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-bundles
 */
class Packages implements JobInterface
{
    use TextHelperTrait;

    const JOB_NAME = 'packages';

    /** @var Packagist */
    private $packagist;

    /** @var PackageRepository */
    private $packageRepository;

    /** @var LoggerInterface */
    private $logger;

    /**
     * IndexPackages constructor.
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
        $startTime = microtime(true);

        $this->logger->info('Start job process', ['job_name' => $this->getJobName()]);

        try {
            $this->getPackagesData();
        } catch (ORMException $exception) {
            $this->logger->critical('Job failed', ['exception' => $exception->getMessage()]);
        }

        $this->logger->info(
            'Job process has finished',
            [
                'job_name'    => $this->getJobName(),
                'passed_time' => $this->getFormattedTime($startTime),
            ]
        );
    }

    /**
     * @return void
     * @throws ORMException
     */
    private function getPackagesData()
    {
        $packageIds = $this->packageRepository->getExistsPackagesIds();
        $packageIdsCount = count($packageIds);
        $packageIdsChunksCount = ceil($packageIdsCount / ApiProvider::POOL_CONCURRENCY);
        $currentChunk = 0;

        foreach (array_chunk($packageIds, ApiProvider::POOL_CONCURRENCY) as $chunk) {
            $this->logger->debug(
                sprintf('Getting data for chunk #%d of %d', ++$currentChunk, $packageIdsChunksCount),
                [
                    'job_name'           => $this->getJobName(),
                    'current_chunk'      => $currentChunk,
                    'current_chunk_size' => count($chunk),
                    'total_chunks'       => $packageIdsChunksCount,
                ]
            );
            $this->getChunkPackages($chunk);
        }
    }

    /**
     * @param array $chunk
     * @return void
     * @throws ORMException
     */
    private function getChunkPackages(array $chunk)
    {
        $packageEntities = new \ArrayObject();
        /** @var \ArrayObject|PackageDTO[] $packages */
        $packages = $this->packagist->getPackages($chunk);

        /** @var PackageDTO $package */
        foreach ($packages as $package) {
            $packageEntities->offsetSet(
                $package->getName(),
                $this->createEntityFromDto($package)
            );
        }

        $this->packageRepository->update($packageEntities);
    }

    /**
     * @param PackageDTO $dto
     * @return Package
     */
    private function createEntityFromDto(PackageDTO $dto): Package
    {
        $entity = new Package($dto->getName());
        $entity
            ->setVersion($dto->getVersion())
            ->setTitle($dto->getDescription())
            ->setRepository($dto->getRepository())
            ->setAuthor($dto->getMaintainers()->offsetGet(0)->getName())
            ->setIcon($dto->getMaintainers()->offsetGet(0)->getAvatarUrl())
            ->setStatInstalls($dto->getDownloads()->getTotal())
            ->setStatDependents($dto->getDependents())
            ->setStatSuggesters($dto->getSuggesters())
            ->setStatStars($dto->getGithub()->getStars())
            ->setStatWatchers($dto->getGithub()->getWatchers())
            ->setStatForks($dto->getGithub()->getForks())
            ->setStatIssues($dto->getGithub()->getOpenIssues())
            ->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')))
        ;

        return $entity;
    }
}
