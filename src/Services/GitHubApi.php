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
use GuzzleHttp\Client as GuzzleClient;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * Class GitHubApi
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-bundles
 */
class GitHubApi
{
    const POOL_CONCURRENCY = 50;
    const COMPOSER_JSON_URL = "https://raw.githubusercontent.com/%s/master/composer.json";

    /** @var PackageRepository */
    private $packageRepository;

    /** @var LoggerInterface */
    private $logger;

    /** @var GuzzleClient */
    private $guzzleClient;

    /**
     * GitHubApi constructor.
     * @param PackageRepository $packageRepository
     * @param LoggerInterface $logger
     * @param GuzzleClient $guzzle
     */
    public function __construct(PackageRepository $packageRepository, LoggerInterface $logger, GuzzleClient $guzzle)
    {
        $this->packageRepository = $packageRepository;
        $this->logger = $logger;
        $this->guzzleClient = $guzzle;
    }

    /**
     * @param array $urls
     * @param string $method
     * @param int $concurrency
     * @return array
     */
    private function getBatchAPIResponse(array $urls, string $method, int $concurrency = self::POOL_CONCURRENCY): array
    {
        $requests = $this->createRequests($urls, $method);
        $responses = Pool::batch($this->guzzleClient, $requests, ['concurrency' => $concurrency]);
        /** @var Response $response */
        foreach ($responses as $key => $response) {
            $responses[$key] = $response->getBody();
        }

        return $responses;
    }

    /**
     * @param array $links
     * @param string $method
     * @return array
     */
    private function createRequests(array $links, string $method): array
    {
        $requests = [];
        foreach ($links as $link) {
            $requests[] = new Request($method, $link);
        }

        return $requests;
    }
}
