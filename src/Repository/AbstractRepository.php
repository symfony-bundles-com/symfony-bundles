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

use Doctrine\DBAL\Driver\PDOConnection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class AbstractRepository
 *
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package symfony-bundles-com/symfony-bundles
 */
abstract class AbstractRepository extends EntityRepository
{
    const RETURN_RES_TYPE_FETCH_ALL = 1;
    const RETURN_RES_TYPE_ROW_COUNT = 2;

    /** @var PDOConnection */
    protected $pdoDB;

    /** @var EntityManager */
    protected $entityManager;

    /**
     * AbstractRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param Mapping\ClassMetadata $class
     */
    public function __construct(EntityManagerInterface $entityManager, Mapping\ClassMetadata $class)
    {
        parent::__construct($entityManager, $class);
        $this->entityManager = $entityManager;
        $this->pdoDB = $entityManager->getConnection();
    }

    /**
     * @param string $value
     * @return string
     */
    protected function quote(string $value): string
    {
        $emptyValues = ['%', '%%', '_'];
        if (($value === 0) || (!empty($value) && !in_array($value, $emptyValues))) {
            return $this->pdoDB->quote($value);
        }
        return 'NULL';
    }

    public function checkConnection()
    {
        if ($this->pdoDB->ping() == false) {
            $this->pdoDB->close();
            $this->pdoDB->connect();
        }
    }

    /**
     * @param string $sql
     * @param bool $returnResult
     * @param int $fetchType
     * @param int $returnResultType
     * @return array|bool|int
     * @throws \Exception
     */
    protected function sqlRequest(
        string $sql,
        bool $returnResult = true,
        int $fetchType = \PDO::FETCH_OBJ,
        int $returnResultType = self::RETURN_RES_TYPE_FETCH_ALL
    ) {
        $this->checkConnection();

        $dbRequest = $this->pdoDB->prepare($sql);

        if (!$dbRequest->execute()) {
            throw new \Exception("Execute failed: ({$dbRequest->errorCode()}) " . $dbRequest->errorInfo()[2]);
        }

        if ($returnResult) {
            switch ($returnResultType) {
                case self::RETURN_RES_TYPE_ROW_COUNT:
                    return $dbRequest->rowCount();
                    break;
                case self::RETURN_RES_TYPE_FETCH_ALL:
                default:
                    return $dbRequest->fetchAll($fetchType);
            }
        } else {
            return true;
        }
    }
}
