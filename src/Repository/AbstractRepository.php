<?php
/**
 * Created by PhpStorm.
 * User: alexeysamara
 * Date: 16.12.2017
 * Time: 18:31
 */

namespace App\Repository;

use Doctrine\DBAL\Driver\PDOConnection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

abstract class AbstractRepository extends EntityRepository
{
    /** @var PDOConnection */
    protected $db;

    /**
     * AbstractRepository constructor.
     * @param EntityManager $em
     * @param Mapping\ClassMetadata $class
     */
    public function __construct(EntityManager $em, Mapping\ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->db = $em->getConnection();
    }
}
