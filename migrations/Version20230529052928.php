<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529052928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employment_contracts (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, country_id INT DEFAULT NULL, employer VARCHAR(255) DEFAULT NULL, salary_per_month DOUBLE PRECISION DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, start_date DATE DEFAULT NULL, tenure VARCHAR(255) DEFAULT NULL, INDEX IDX_BFC955A58C03F15C (employee_id), INDEX IDX_BFC955A5F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employment_contracts ADD CONSTRAINT FK_BFC955A58C03F15C FOREIGN KEY (employee_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employment_contracts ADD CONSTRAINT FK_BFC955A5F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE criminal_record_check ADD file VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tenancy_agreements ADD file VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utility_bills ADD file VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE employment_contracts');
        $this->addSql('ALTER TABLE criminal_record_check DROP file');
        $this->addSql('ALTER TABLE tenancy_agreements DROP file');
        $this->addSql('ALTER TABLE utility_bills DROP file');
    }
}
