<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250520023141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE rdv ADD CONSTRAINT FK_10C31F867C6DED13 FOREIGN KEY (office_type_of_service_id) REFERENCES office_type_of_service (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_10C31F867C6DED13 ON rdv (office_type_of_service_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F867C6DED13
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_10C31F867C6DED13 ON rdv
        SQL);
    }
}
