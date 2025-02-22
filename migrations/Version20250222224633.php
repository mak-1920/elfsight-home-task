<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250222224633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comments (id INT NOT NULL, episode_id INT DEFAULT NULL, author_name VARCHAR(255) NOT NULL, score DOUBLE PRECISION DEFAULT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F9E962A362B62A0 ON comments (episode_id)');
        $this->addSql('CREATE TABLE episodes (id INT NOT NULL, name VARCHAR(255) NOT NULL, air_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN episodes.air_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A362B62A0 FOREIGN KEY (episode_id) REFERENCES episodes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE comments DROP CONSTRAINT FK_5F9E962A362B62A0');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE episodes');
    }
}
