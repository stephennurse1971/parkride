<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610134454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE passports ADD reviewed_by_id INT DEFAULT NULL, ADD reviewed VARCHAR(255) DEFAULT NULL, ADD reviewed_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE passports ADD CONSTRAINT FK_1560E557FC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1560E557FC6B21F1 ON passports (reviewed_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE passports DROP FOREIGN KEY FK_1560E557FC6B21F1');
        $this->addSql('DROP INDEX IDX_1560E557FC6B21F1 ON passports');
        $this->addSql('ALTER TABLE passports DROP reviewed_by_id, DROP reviewed, DROP reviewed_date');
    }
}
