<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260818132442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3AF346685E237E06 (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE instruments (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, instrument_condition VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, daily_rental_price NUMERIC(10, 2) NOT NULL, image VARCHAR(255) DEFAULT NULL, is_active TINYINT NOT NULL, category_id INT NOT NULL, INDEX IDX_E350DE0B12469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE rental_requests (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, purpose LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, reviewed_by INT DEFAULT NULL, rejection_reason LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, user_id INT NOT NULL, instrument_id INT NOT NULL, INDEX IDX_4BE3CF62A76ED395 (user_id), INDEX IDX_4BE3CF62CF11D9C (instrument_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, is_blocked TINYINT NOT NULL, image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE instruments ADD CONSTRAINT FK_E350DE0B12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE rental_requests ADD CONSTRAINT FK_4BE3CF62A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rental_requests ADD CONSTRAINT FK_4BE3CF62CF11D9C FOREIGN KEY (instrument_id) REFERENCES instruments (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instruments DROP FOREIGN KEY FK_E350DE0B12469DE2');
        $this->addSql('ALTER TABLE rental_requests DROP FOREIGN KEY FK_4BE3CF62A76ED395');
        $this->addSql('ALTER TABLE rental_requests DROP FOREIGN KEY FK_4BE3CF62CF11D9C');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE instruments');
        $this->addSql('DROP TABLE rental_requests');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
