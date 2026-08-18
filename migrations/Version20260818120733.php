<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260818120733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rental_requests (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, purpose LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, reviewed_by INT DEFAULT NULL, rejection_reason LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, user_id INT NOT NULL, instrument_id INT NOT NULL, INDEX IDX_4BE3CF62A76ED395 (user_id), INDEX IDX_4BE3CF62CF11D9C (instrument_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE rental_requests ADD CONSTRAINT FK_4BE3CF62A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rental_requests ADD CONSTRAINT FK_4BE3CF62CF11D9C FOREIGN KEY (instrument_id) REFERENCES instruments (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rental_requests DROP FOREIGN KEY FK_4BE3CF62A76ED395');
        $this->addSql('ALTER TABLE rental_requests DROP FOREIGN KEY FK_4BE3CF62CF11D9C');
        $this->addSql('DROP TABLE rental_requests');
    }
}
