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

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;

/**
 * Class GitHubApi
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-bundles
 */
class GitHubApi
{
    const POOL_CONCURRENCY = 50;
    const ALLOWED_STATUS_CODES = [200, 301, 302];
    const RAW_FILE_URL = 'https://raw.githubusercontent.com/%s/master/%s';

    /** @var GuzzleClient */
    private $guzzleClient;

    /** @var LoggerInterface */
    private $logger;

    /**
     * GitHubApi constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->guzzleClient = new GuzzleClient();
    }

    /**
     * @param string $packageId
     * @param string $fileName
     * @return string
     */
    public function generateRawFileUrl(string $packageId, string $fileName): string
    {
        return sprintf(self::RAW_FILE_URL, $packageId, $fileName);
    }

    /**
     * @param array $urls
     * @param string $method
     * @param int $concurrency
     * @return array
     */
    public function getBatchAPIResponse(
        array $urls,
        string $method = 'GET',
        int $concurrency = self::POOL_CONCURRENCY
    ): array {
        $requests = $this->createRequests($urls, $method);
        $responses = Pool::batch($this->guzzleClient, $requests, ['concurrency' => $concurrency]);
        /** @var Response $response */
        foreach ($responses as $key => $response) {
            if (!in_array($response->getStatusCode(), self::ALLOWED_STATUS_CODES)) {
                $this->logger->warning('Can\'t get file', [
                    'file_url' => $urls[$key],
                    'response_code' => $response->getStatusCode()
                ]);

                continue;
            }

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
