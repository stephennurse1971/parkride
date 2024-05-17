<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230807110900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cms_dynamic ADD webpage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_dynamic ADD CONSTRAINT FK_154705A5E20F2920 FOREIGN KEY (webpage_id) REFERENCES services_offered (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_154705A5E20F2920 ON cms_dynamic (webpage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cms_dynamic DROP FOREIGN KEY FK_154705A5E20F2920');
        $this->addSql('DROP INDEX UNIQ_154705A5E20F2920 ON cms_dynamic');
        $this->addSql('ALTER TABLE cms_dynamic DROP webpage_id');
    }
}
