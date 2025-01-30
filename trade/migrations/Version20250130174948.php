<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130174948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_brand (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C3F97C8F2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_car (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, model_id INT NOT NULL, price INT NOT NULL, INDEX IDX_7C9AC62D44F5D008 (brand_id), INDEX IDX_7C9AC62D7975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_model (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, photo_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_83EF70E2B36786B (title), INDEX IDX_83EF70E44F5D008 (brand_id), UNIQUE INDEX UNIQ_83EF70E7E9E4C8C (photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_photo (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit_program (id INT AUTO_INCREMENT NOT NULL, min_down_payment_percent DOUBLE PRECISION NOT NULL, interest_rate DOUBLE PRECISION NOT NULL, title VARCHAR(255) NOT NULL, is_default TINYINT(1) NOT NULL, loan_term INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit_request (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, program_id INT NOT NULL, initial_payment INT NOT NULL, loan_term INT NOT NULL, INDEX IDX_113E8B0C3C6F69F (car_id), INDEX IDX_113E8B03EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_car ADD CONSTRAINT FK_7C9AC62D44F5D008 FOREIGN KEY (brand_id) REFERENCES car_brand (id)');
        $this->addSql('ALTER TABLE car_car ADD CONSTRAINT FK_7C9AC62D7975B7E7 FOREIGN KEY (model_id) REFERENCES car_model (id)');
        $this->addSql('ALTER TABLE car_model ADD CONSTRAINT FK_83EF70E44F5D008 FOREIGN KEY (brand_id) REFERENCES car_brand (id)');
        $this->addSql('ALTER TABLE car_model ADD CONSTRAINT FK_83EF70E7E9E4C8C FOREIGN KEY (photo_id) REFERENCES car_photo (id)');
        $this->addSql('ALTER TABLE credit_request ADD CONSTRAINT FK_113E8B0C3C6F69F FOREIGN KEY (car_id) REFERENCES car_car (id)');
        $this->addSql('ALTER TABLE credit_request ADD CONSTRAINT FK_113E8B03EB8070A FOREIGN KEY (program_id) REFERENCES credit_program (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car_car DROP FOREIGN KEY FK_7C9AC62D44F5D008');
        $this->addSql('ALTER TABLE car_car DROP FOREIGN KEY FK_7C9AC62D7975B7E7');
        $this->addSql('ALTER TABLE car_model DROP FOREIGN KEY FK_83EF70E44F5D008');
        $this->addSql('ALTER TABLE car_model DROP FOREIGN KEY FK_83EF70E7E9E4C8C');
        $this->addSql('ALTER TABLE credit_request DROP FOREIGN KEY FK_113E8B0C3C6F69F');
        $this->addSql('ALTER TABLE credit_request DROP FOREIGN KEY FK_113E8B03EB8070A');
        $this->addSql('DROP TABLE car_brand');
        $this->addSql('DROP TABLE car_car');
        $this->addSql('DROP TABLE car_model');
        $this->addSql('DROP TABLE car_photo');
        $this->addSql('DROP TABLE credit_program');
        $this->addSql('DROP TABLE credit_request');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
