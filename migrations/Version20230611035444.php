<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230611035444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE birth_death_marriage_certificates ADD reviewed_by_id INT DEFAULT NULL, ADD reviewed VARCHAR(255) DEFAULT NULL, ADD reviewed_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE birth_death_marriage_certificates ADD CONSTRAINT FK_ED495B29FC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_ED495B29FC6B21F1 ON birth_death_marriage_certificates (reviewed_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE birth_death_marriage_certificates DROP FOREIGN KEY FK_ED495B29FC6B21F1');
        $this->addSql('DROP INDEX IDX_ED495B29FC6B21F1 ON birth_death_marriage_certificates');
        $this->addSql('ALTER TABLE birth_death_marriage_certificates DROP reviewed_by_id, DROP reviewed, DROP reviewed_date');
    }
}
