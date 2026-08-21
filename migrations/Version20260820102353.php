<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260820102353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rental_requests ADD CONSTRAINT FK_4BE3CF6285D7FB47 FOREIGN KEY (reviewed_by) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4BE3CF6285D7FB47 ON rental_requests (reviewed_by)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rental_requests DROP FOREIGN KEY FK_4BE3CF6285D7FB47');
        $this->addSql('DROP INDEX IDX_4BE3CF6285D7FB47 ON rental_requests');
    }
}
