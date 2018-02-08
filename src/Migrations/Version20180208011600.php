<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180208011600 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE sb_packages ADD COLUMN symfony_1 TINYINT(1) DEFAULT 0 AFTER stat_issues;");
        $this->addSql("ALTER TABLE sb_packages ADD COLUMN symfony_2 TINYINT(1) DEFAULT 0 AFTER symfony_1;");
        $this->addSql("ALTER TABLE sb_packages ADD COLUMN symfony_3 TINYINT(1) DEFAULT 0 AFTER symfony_2;");
        $this->addSql("ALTER TABLE sb_packages ADD COLUMN symfony_4 TINYINT(1) DEFAULT 0 AFTER symfony_3;");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE sb_packages DROP COLUMN symfony_1;");
        $this->addSql("ALTER TABLE sb_packages DROP COLUMN symfony_2;");
        $this->addSql("ALTER TABLE sb_packages DROP COLUMN symfony_3;");
        $this->addSql("ALTER TABLE sb_packages DROP COLUMN symfony_4;");
    }
}
