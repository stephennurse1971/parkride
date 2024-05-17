<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529230021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE business_contacts ADD business_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE business_contacts ADD CONSTRAINT FK_3B701BE5987F37DE FOREIGN KEY (business_type_id) REFERENCES business_types (id)');
        $this->addSql('CREATE INDEX IDX_3B701BE5987F37DE ON business_contacts (business_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE business_contacts DROP FOREIGN KEY FK_3B701BE5987F37DE');
        $this->addSql('DROP INDEX IDX_3B701BE5987F37DE ON business_contacts');
        $this->addSql('ALTER TABLE business_contacts DROP business_type_id');
    }
}
