<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529225927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE business_contacts ADD public_private VARCHAR(255) DEFAULT NULL, ADD address_street VARCHAR(255) DEFAULT NULL, ADD address_city VARCHAR(255) DEFAULT NULL, ADD address_post_code VARCHAR(255) DEFAULT NULL, ADD address_country VARCHAR(255) DEFAULT NULL, ADD business_or_person VARCHAR(255) DEFAULT NULL, DROP address, DROP business_type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE business_contacts ADD address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD business_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP public_private, DROP address_street, DROP address_city, DROP address_post_code, DROP address_country, DROP business_or_person');
    }
}
