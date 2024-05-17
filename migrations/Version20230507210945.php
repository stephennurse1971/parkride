<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230507210945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cms (id INT AUTO_INCREMENT NOT NULL, company_email VARCHAR(255) DEFAULT NULL, company_tel VARCHAR(255) NOT NULL, company_address VARCHAR(255) DEFAULT NULL, cms1_en LONGTEXT DEFAULT NULL, cms2_en LONGTEXT DEFAULT NULL, cms3_en LONGTEXT DEFAULT NULL, cms4_en LONGTEXT DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, linked_in VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cms');
    }
}
