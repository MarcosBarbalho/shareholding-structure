<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241018081505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE associate (
          id SERIAL NOT NULL,
          organization_id INT NOT NULL,
          name VARCHAR(255) NOT NULL,
          document VARCHAR(255) NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CCE5D25D8698A76 ON associate (document)');
        $this->addSql('CREATE INDEX IDX_CCE5D2532C8A3DE ON associate (organization_id)');
        $this->addSql('ALTER TABLE
          associate
        ADD
          CONSTRAINT FK_CCE5D2532C8A3DE FOREIGN KEY (organization_id)
            REFERENCES organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE associate DROP CONSTRAINT FK_CCE5D2532C8A3DE');
        $this->addSql('DROP TABLE associate');
    }
}
