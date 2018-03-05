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
use App\Repository\PackageRepository;
use App\Services\GitHubApi;
use App\Traits\TextHelperTrait;
use Psr\Log\LoggerInterface;

/**
 * Class GetDependencies
 *
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-bundles
 */
class GetDependencies implements JobInterface
{
    use TextHelperTrait;

    const JOB_NAME = 'get_dependencies';
    const COMPOSER_FILE = 'composer.json';

    /** @var GitHubApi */
    private $github;

    /** @var PackageRepository */
    private $packageRepository;

    /** @var LoggerInterface */
    private $logger;

    /**
     * GetDependencies constructor.
     * @param GitHubApi $github
     * @param PackageRepository $packageRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        GitHubApi $github,
        PackageRepository $packageRepository,
        LoggerInterface $logger
    ) {
        $this->github = $github;
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

        $composerJsonLinks = $this->getComposerJsonLinks();

        $this->processGettingDependencies($composerJsonLinks);

        $this->logger->info(
            'Job process has finished',
            [
                'job_name'    => $this->getJobName(),
                'passed_time' => $this->getFormattedTime($startTime)
            ]
        );
    }

    /**
     * @return array
     */
    private function getComposerJsonLinks(): array
    {
        $composerJsonLinks = [];

        $packageIds = $this->packageRepository->getExistsPackagesIds();

        foreach ($packageIds as $packageId) {
            $composerJsonLinks[$packageId] = $this->github->generateRawFileUrl($packageId, self::COMPOSER_FILE);
        }

        return $composerJsonLinks;
    }

    /**
     * @param array $composerJsonLinks
     */
    private function processGettingDependencies(array $composerJsonLinks)
    {
        foreach (array_chunk($composerJsonLinks, GitHubApi::POOL_CONCURRENCY) as $chunk) {
            $packageEntities = $this->getPackagesWithDependencies($chunk);
            $this->updatePackagesDependencies($packageEntities);
        }
    }

    /**
     * @param array $jsonLinks
     * @return \ArrayObject|Package[]
     */
    private function getPackagesWithDependencies(array $jsonLinks): \ArrayObject
    {
        $packageEntities = new \ArrayObject();
        $jsonRaws = $this->github->getBatchAPIResponse($jsonLinks);
    }

    /**
     * @param \ArrayObject|Package[] $packageEntities
     */
    private function updatePackagesDependencies(\ArrayObject $packageEntities)
    {
        // TODO: implement
    }
}
