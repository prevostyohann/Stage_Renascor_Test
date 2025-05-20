<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250520145200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE profession_office DROP FOREIGN KEY FK_CBBB6557FDEF8996
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profession_office DROP FOREIGN KEY FK_CBBB6557FFA0C224
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE profession_office
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE profession_office (profession_id INT NOT NULL, office_id INT NOT NULL, INDEX IDX_CBBB6557FDEF8996 (profession_id), INDEX IDX_CBBB6557FFA0C224 (office_id), PRIMARY KEY(profession_id, office_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profession_office ADD CONSTRAINT FK_CBBB6557FDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profession_office ADD CONSTRAINT FK_CBBB6557FFA0C224 FOREIGN KEY (office_id) REFERENCES office (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
    }
}
