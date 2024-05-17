<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821064920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documentation_errors DROP FOREIGN KEY FK_698AFA4BED5CA9E6');
        $this->addSql('DROP INDEX IDX_698AFA4BED5CA9E6 ON documentation_errors');
        $this->addSql('ALTER TABLE documentation_errors DROP service_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documentation_errors ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE documentation_errors ADD CONSTRAINT FK_698AFA4BED5CA9E6 FOREIGN KEY (service_id) REFERENCES services_offered (id)');
        $this->addSql('CREATE INDEX IDX_698AFA4BED5CA9E6 ON documentation_errors (service_id)');
    }
}
