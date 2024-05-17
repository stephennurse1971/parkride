<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508111529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE passports ADD country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE passports ADD CONSTRAINT FK_1560E557F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_1560E557F92F3E70 ON passports (country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE passports DROP FOREIGN KEY FK_1560E557F92F3E70');
        $this->addSql('DROP INDEX IDX_1560E557F92F3E70 ON passports');
        $this->addSql('ALTER TABLE passports DROP country_id');
    }
}
