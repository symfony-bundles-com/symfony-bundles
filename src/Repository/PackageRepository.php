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

/**
 * Class PackageRepository
 *
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package symfony-bundles-com/symfony-bundles
 */
class PackageRepository extends AbstractRepository
{
    const TABLE_NAME = 'sb_packages';

    public function getExistsPackagesIds(): array
    {
        $sql = sprintf(
            "SELECT package_id FROM %s",
            self::TABLE_NAME
        );

        try {
            return $this->sqlRequest($sql);
        } catch (\Exception $e) {
            return [];
        }

    }
}