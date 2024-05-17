<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230611040742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE birth_death_marriage_certificates ADD comments VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE criminal_record_check ADD comments VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE driving_license ADD comments VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE employment_contracts ADD comments VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE financial_statements ADD comments VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE health_insurance ADD comments VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE medical ADD comments VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE school_attendance_certificates ADD comments VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tenancy_agreements ADD comments VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utility_bills ADD comments VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE birth_death_marriage_certificates DROP comments');
        $this->addSql('ALTER TABLE criminal_record_check DROP comments');
        $this->addSql('ALTER TABLE driving_license DROP comments');
        $this->addSql('ALTER TABLE employment_contracts DROP comments');
        $this->addSql('ALTER TABLE financial_statements DROP comments');
        $this->addSql('ALTER TABLE health_insurance DROP comments');
        $this->addSql('ALTER TABLE medical DROP comments');
        $this->addSql('ALTER TABLE school_attendance_certificates DROP comments');
        $this->addSql('ALTER TABLE tenancy_agreements DROP comments');
        $this->addSql('ALTER TABLE utility_bills DROP comments');
    }
}
