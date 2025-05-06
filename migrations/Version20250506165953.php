<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250506165953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE office ADD office_street_name VARCHAR(255) DEFAULT NULL, CHANGE office_country office_country VARCHAR(30) DEFAULT NULL, CHANGE score score INT DEFAULT NULL, CHANGE vip vip TINYINT(1) DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE office DROP office_street_name, CHANGE office_country office_country VARCHAR(30) NOT NULL, CHANGE score score INT NOT NULL, CHANGE vip vip TINYINT(1) NOT NULL
        SQL);
    }
}
