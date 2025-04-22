<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416161007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE office (id SERIAL NOT NULL, user_id INT NOT NULL, business_name VARCHAR(255) NOT NULL, siret VARCHAR(20) DEFAULT NULL, registration_document VARCHAR(255) DEFAULT NULL, website_link VARCHAR(255) DEFAULT NULL, office_address VARCHAR(255) DEFAULT NULL, office_phone VARCHAR(20) DEFAULT NULL, profile_picture VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, points INT DEFAULT 0 NOT NULL, vip BOOLEAN DEFAULT false NOT NULL, status VARCHAR(20) DEFAULT 'pending' NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_74516B02A76ED395 ON office (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office ADD CONSTRAINT FK_74516B02A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users RENAME COLUMN fistname TO firstname
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON users (username)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office DROP CONSTRAINT FK_74516B02A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE office
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_IDENTIFIER_USERNAME
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users RENAME COLUMN firstname TO fistname
        SQL);
    }
}
