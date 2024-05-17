<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230617141815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD address_country_id INT DEFAULT NULL, ADD address_street VARCHAR(255) DEFAULT NULL, ADD address_city VARCHAR(255) DEFAULT NULL, ADD address_post_code VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64981B2B6EE FOREIGN KEY (address_country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64981B2B6EE ON user (address_country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64981B2B6EE');
        $this->addSql('DROP INDEX IDX_8D93D64981B2B6EE ON user');
        $this->addSql('ALTER TABLE user DROP address_country_id, DROP address_street, DROP address_city, DROP address_post_code');
    }
}
