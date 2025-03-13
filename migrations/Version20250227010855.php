<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250227010855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patients (id INT AUTO_INCREMENT NOT NULL, document_type VARCHAR(50) NOT NULL, document VARCHAR(50) NOT NULL, first_name VARCHAR(100) NOT NULL, second_name VARCHAR(100) DEFAULT NULL, first_last_name VARCHAR(100) NOT NULL, second_last_name VARCHAR(100) DEFAULT NULL, birthday DATETIME NOT NULL, phone VARCHAR(20) NOT NULL, second_phone VARCHAR(20) DEFAULT NULL, department VARCHAR(100) NOT NULL, municipality VARCHAR(100) NOT NULL, address LONGTEXT NOT NULL, email VARCHAR(255) NOT NULL, gender VARCHAR(10) NOT NULL, blood_group VARCHAR(10) NOT NULL, rh VARCHAR(10) NOT NULL, process_type VARCHAR(50) NOT NULL, entity_health VARCHAR(100) NOT NULL, regime VARCHAR(50) NOT NULL, appointment_type VARCHAR(50) NOT NULL, service VARCHAR(100) NOT NULL, authorization_number VARCHAR(50) DEFAULT NULL, image_path VARCHAR(255) DEFAULT NULL, path_image_eps VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_2CCC2E2CD8698A76 (document), UNIQUE INDEX UNIQ_2CCC2E2CE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE patients');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
