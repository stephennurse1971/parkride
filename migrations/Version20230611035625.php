<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230611035625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employment_contracts ADD reviewed_by_id INT DEFAULT NULL, ADD reviewed VARCHAR(255) DEFAULT NULL, ADD reviewed_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE employment_contracts ADD CONSTRAINT FK_BFC955A5FC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BFC955A5FC6B21F1 ON employment_contracts (reviewed_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employment_contracts DROP FOREIGN KEY FK_BFC955A5FC6B21F1');
        $this->addSql('DROP INDEX IDX_BFC955A5FC6B21F1 ON employment_contracts');
        $this->addSql('ALTER TABLE employment_contracts DROP reviewed_by_id, DROP reviewed, DROP reviewed_date');
    }
}
