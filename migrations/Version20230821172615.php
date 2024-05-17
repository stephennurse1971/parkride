<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821172615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE email_templates ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE email_templates ADD CONSTRAINT FK_6023E2A5ED5CA9E6 FOREIGN KEY (service_id) REFERENCES services_offered (id)');
        $this->addSql('CREATE INDEX IDX_6023E2A5ED5CA9E6 ON email_templates (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE email_templates DROP FOREIGN KEY FK_6023E2A5ED5CA9E6');
        $this->addSql('DROP INDEX IDX_6023E2A5ED5CA9E6 ON email_templates');
        $this->addSql('ALTER TABLE email_templates DROP service_id');
    }
}
