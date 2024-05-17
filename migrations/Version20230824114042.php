<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230824114042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE passports_documentation_errors (passports_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_CC036AD661099BE1 (passports_id), INDEX IDX_CC036AD6F9B0C471 (documentation_errors_id), PRIMARY KEY(passports_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE passports_documentation_errors ADD CONSTRAINT FK_CC036AD661099BE1 FOREIGN KEY (passports_id) REFERENCES passports (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE passports_documentation_errors ADD CONSTRAINT FK_CC036AD6F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE passports_documentation_errors');
    }
}
