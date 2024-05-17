<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508104119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE driving_license (id INT AUTO_INCREMENT NOT NULL, driving_license_holder_id INT DEFAULT NULL, driving_license_country_id INT DEFAULT NULL, license_number VARCHAR(255) DEFAULT NULL, issue_date DATE DEFAULT NULL, expiry_date DATE DEFAULT NULL, codes VARCHAR(255) DEFAULT NULL, last_name_on_license VARCHAR(255) DEFAULT NULL, first_name_on_license VARCHAR(255) DEFAULT NULL, license_scan1 VARCHAR(255) DEFAULT NULL, license_scan2 VARCHAR(255) DEFAULT NULL, INDEX IDX_CC361A3361479D1C (driving_license_holder_id), INDEX IDX_CC361A336B421914 (driving_license_country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE driving_license ADD CONSTRAINT FK_CC361A3361479D1C FOREIGN KEY (driving_license_holder_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE driving_license ADD CONSTRAINT FK_CC361A336B421914 FOREIGN KEY (driving_license_country_id) REFERENCES countries (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE driving_license');
    }
}
