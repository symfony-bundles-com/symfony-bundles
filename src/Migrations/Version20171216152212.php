<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171216152212 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE IF NOT EXISTS sb_packages
            (
              id                INT AUTO_INCREMENT
                PRIMARY KEY,
              package_id        VARCHAR(255)    NOT NULL,
              version           VARCHAR(25)     NULL,
              title             VARCHAR(255)    NULL,
              description       LONGTEXT        NULL,
              description_clean LONGTEXT        NULL,
              author            VARCHAR(255)    NULL,
              stat_installs     INT DEFAULT '0' NULL,
              stat_dependents   INT DEFAULT '0' NULL,
              stat_suggesters   INT DEFAULT '0' NULL,
              stat_stars        INT DEFAULT '0' NULL,
              stat_watchers     INT DEFAULT '0' NULL,
              stat_forks        INT DEFAULT '0' NULL,
              stat_issues       INT DEFAULT '0' NULL,
              CONSTRAINT sb_packages_package_id_uindex
              UNIQUE (package_id)
            ) ENGINE = InnoDB;
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE IF EXISTS sb_packages;");
    }
}
