<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529052425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE criminal_record_check (id INT AUTO_INCREMENT NOT NULL, applicant_id INT DEFAULT NULL, country_id INT DEFAULT NULL, date DATE DEFAULT NULL, convictions TINYINT(1) DEFAULT NULL, convictions_commentary VARCHAR(255) DEFAULT NULL, INDEX IDX_4317033B97139001 (applicant_id), INDEX IDX_4317033BF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE criminal_record_check ADD CONSTRAINT FK_4317033B97139001 FOREIGN KEY (applicant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE criminal_record_check ADD CONSTRAINT FK_4317033BF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE criminal_record_check');
    }
}
