<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250429090619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE certificate_owned (id INT AUTO_INCREMENT NOT NULL, profession_id INT NOT NULL, user_id INT NOT NULL, certificate_owned_link VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_12138388FDEF8996 (profession_id), INDEX IDX_12138388A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE degree_owned (id INT AUTO_INCREMENT NOT NULL, profession_id INT NOT NULL, user_id INT NOT NULL, degree_owned_link VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DDA78CB7FDEF8996 (profession_id), INDEX IDX_DDA78CB7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, faq_category_id INT NOT NULL, question VARCHAR(255) NOT NULL, answer LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E8FF75CCA76ED395 (user_id), INDEX IDX_E8FF75CCF689B0DB (faq_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE faq_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE office (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, business_name VARCHAR(30) NOT NULL, siret VARCHAR(20) NOT NULL, business_proof VARCHAR(255) DEFAULT NULL, personal_site_link VARCHAR(255) DEFAULT NULL, profile_photo_link VARCHAR(255) DEFAULT NULL, office_phone VARCHAR(20) NOT NULL, office_street_number VARCHAR(10) NOT NULL, office_address VARCHAR(255) NOT NULL, office_postal_code INT NOT NULL, office_city VARCHAR(30) NOT NULL, office_country VARCHAR(30) NOT NULL, office_latitude DOUBLE PRECISION NOT NULL, office_longitude DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, score INT NOT NULL, vip TINYINT(1) NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_74516B02A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE office_profession (office_id INT NOT NULL, profession_id INT NOT NULL, INDEX IDX_E5807108FFA0C224 (office_id), INDEX IDX_E5807108FDEF8996 (profession_id), PRIMARY KEY(office_id, profession_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE office_closure (id INT AUTO_INCREMENT NOT NULL, office_id INT NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3C5BEE93FFA0C224 (office_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE office_photo (id INT AUTO_INCREMENT NOT NULL, office_id INT NOT NULL, office_photo_link VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1DEC2798FFA0C224 (office_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE office_type_of_service (id INT AUTO_INCREMENT NOT NULL, price DOUBLE PRECISION NOT NULL, currency VARCHAR(15) NOT NULL, duration VARCHAR(255) NOT NULL COMMENT '(DC2Type:dateinterval)', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE office_type_of_service_office (office_type_of_service_id INT NOT NULL, office_id INT NOT NULL, INDEX IDX_CDE809DD7C6DED13 (office_type_of_service_id), INDEX IDX_CDE809DDFFA0C224 (office_id), PRIMARY KEY(office_type_of_service_id, office_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE office_type_of_service_type_of_service (office_type_of_service_id INT NOT NULL, type_of_service_id INT NOT NULL, INDEX IDX_D0B3DCA67C6DED13 (office_type_of_service_id), INDEX IDX_D0B3DCA674E5DF46 (type_of_service_id), PRIMARY KEY(office_type_of_service_id, type_of_service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE profession (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE profession_office (profession_id INT NOT NULL, office_id INT NOT NULL, INDEX IDX_CBBB6557FDEF8996 (profession_id), INDEX IDX_CBBB6557FFA0C224 (office_id), PRIMARY KEY(profession_id, office_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, office_id INT NOT NULL, office_type_of_service_id INT NOT NULL, date DATE NOT NULL, hour_of_rdv TIME NOT NULL, end_of_rdv TIME NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_10C31F86A76ED395 (user_id), INDEX IDX_10C31F86FFA0C224 (office_id), INDEX IDX_10C31F867C6DED13 (office_type_of_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, office_id INT NOT NULL, note INT NOT NULL, comment VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_794381C6A76ED395 (user_id), INDEX IDX_794381C6FFA0C224 (office_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, profession_id INT NOT NULL, name VARCHAR(60) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F3D7A08EFDEF8996 (profession_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE time_configuration (id INT AUTO_INCREMENT NOT NULL, office_id INT NOT NULL, day VARCHAR(255) NOT NULL, open_time TIME NOT NULL, close_time TIME NOT NULL, rdv_interval VARCHAR(255) DEFAULT NULL COMMENT '(DC2Type:dateinterval)', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2D33F758FFA0C224 (office_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE type_of_service (id INT AUTO_INCREMENT NOT NULL, speciality_id INT NOT NULL, name VARCHAR(60) NOT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1EBBD463B5A08D7 (speciality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(30) NOT NULL, last_name VARCHAR(30) NOT NULL, first_name VARCHAR(30) NOT NULL, street_number VARCHAR(10) NOT NULL, address VARCHAR(255) NOT NULL, postal_code INT NOT NULL, city VARCHAR(30) NOT NULL, country VARCHAR(30) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, birth_date DATE NOT NULL, phone_number VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE certificate_owned ADD CONSTRAINT FK_12138388FDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE certificate_owned ADD CONSTRAINT FK_12138388A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE degree_owned ADD CONSTRAINT FK_DDA78CB7FDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE degree_owned ADD CONSTRAINT FK_DDA78CB7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CCF689B0DB FOREIGN KEY (faq_category_id) REFERENCES faq_category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office ADD CONSTRAINT FK_74516B02A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_profession ADD CONSTRAINT FK_E5807108FFA0C224 FOREIGN KEY (office_id) REFERENCES office (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_profession ADD CONSTRAINT FK_E5807108FDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_closure ADD CONSTRAINT FK_3C5BEE93FFA0C224 FOREIGN KEY (office_id) REFERENCES office (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_photo ADD CONSTRAINT FK_1DEC2798FFA0C224 FOREIGN KEY (office_id) REFERENCES office (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_type_of_service_office ADD CONSTRAINT FK_CDE809DD7C6DED13 FOREIGN KEY (office_type_of_service_id) REFERENCES office_type_of_service (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_type_of_service_office ADD CONSTRAINT FK_CDE809DDFFA0C224 FOREIGN KEY (office_id) REFERENCES office (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_type_of_service_type_of_service ADD CONSTRAINT FK_D0B3DCA67C6DED13 FOREIGN KEY (office_type_of_service_id) REFERENCES office_type_of_service (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_type_of_service_type_of_service ADD CONSTRAINT FK_D0B3DCA674E5DF46 FOREIGN KEY (type_of_service_id) REFERENCES type_of_service (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profession_office ADD CONSTRAINT FK_CBBB6557FDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profession_office ADD CONSTRAINT FK_CBBB6557FFA0C224 FOREIGN KEY (office_id) REFERENCES office (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86FFA0C224 FOREIGN KEY (office_id) REFERENCES office (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rdv ADD CONSTRAINT FK_10C31F867C6DED13 FOREIGN KEY (office_type_of_service_id) REFERENCES office_type_of_service (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE review ADD CONSTRAINT FK_794381C6FFA0C224 FOREIGN KEY (office_id) REFERENCES office (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08EFDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE time_configuration ADD CONSTRAINT FK_2D33F758FFA0C224 FOREIGN KEY (office_id) REFERENCES office (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE type_of_service ADD CONSTRAINT FK_1EBBD463B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE certificate_owned DROP FOREIGN KEY FK_12138388FDEF8996
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE certificate_owned DROP FOREIGN KEY FK_12138388A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE degree_owned DROP FOREIGN KEY FK_DDA78CB7FDEF8996
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE degree_owned DROP FOREIGN KEY FK_DDA78CB7A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CCA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CCF689B0DB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office DROP FOREIGN KEY FK_74516B02A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_profession DROP FOREIGN KEY FK_E5807108FFA0C224
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_profession DROP FOREIGN KEY FK_E5807108FDEF8996
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_closure DROP FOREIGN KEY FK_3C5BEE93FFA0C224
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_photo DROP FOREIGN KEY FK_1DEC2798FFA0C224
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_type_of_service_office DROP FOREIGN KEY FK_CDE809DD7C6DED13
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_type_of_service_office DROP FOREIGN KEY FK_CDE809DDFFA0C224
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_type_of_service_type_of_service DROP FOREIGN KEY FK_D0B3DCA67C6DED13
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE office_type_of_service_type_of_service DROP FOREIGN KEY FK_D0B3DCA674E5DF46
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profession_office DROP FOREIGN KEY FK_CBBB6557FDEF8996
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profession_office DROP FOREIGN KEY FK_CBBB6557FFA0C224
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86FFA0C224
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F867C6DED13
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE review DROP FOREIGN KEY FK_794381C6A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE review DROP FOREIGN KEY FK_794381C6FFA0C224
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE speciality DROP FOREIGN KEY FK_F3D7A08EFDEF8996
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE time_configuration DROP FOREIGN KEY FK_2D33F758FFA0C224
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE type_of_service DROP FOREIGN KEY FK_1EBBD463B5A08D7
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE certificate_owned
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE degree_owned
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE faq
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE faq_category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE office
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE office_profession
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE office_closure
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE office_photo
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE office_type_of_service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE office_type_of_service_office
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE office_type_of_service_type_of_service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE profession
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE profession_office
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE rdv
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE review
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE speciality
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE time_configuration
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE type_of_service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
    }
}
