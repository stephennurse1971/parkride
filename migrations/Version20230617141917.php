<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230617141917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494DEAF165');
        $this->addSql('DROP INDEX IDX_8D93D6494DEAF165 ON user');
        $this->addSql('ALTER TABLE user DROP current_address_country_id, DROP current_address');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD current_address_country_id INT DEFAULT NULL, ADD current_address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494DEAF165 FOREIGN KEY (current_address_country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494DEAF165 ON user (current_address_country_id)');
    }
}
