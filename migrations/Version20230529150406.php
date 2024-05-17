<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529150406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services_offered ADD docs_passport TINYINT(1) DEFAULT NULL, ADD docs_tenancy_agreement TINYINT(1) DEFAULT NULL, ADD docs_utility_bill TINYINT(1) DEFAULT NULL, ADD docs_employment_contract TINYINT(1) DEFAULT NULL, ADD docs_financial_statements TINYINT(1) DEFAULT NULL, ADD docs_p60 TINYINT(1) DEFAULT NULL, ADD docs_school_attendance_certificate TINYINT(1) DEFAULT NULL, ADD docs_criminal_record_check TINYINT(1) DEFAULT NULL, ADD docs_health_insurance TINYINT(1) DEFAULT NULL, ADD docs_medical TINYINT(1) DEFAULT NULL, ADD docs_driving_license TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services_offered DROP docs_passport, DROP docs_tenancy_agreement, DROP docs_utility_bill, DROP docs_employment_contract, DROP docs_financial_statements, DROP docs_p60, DROP docs_school_attendance_certificate, DROP docs_criminal_record_check, DROP docs_health_insurance, DROP docs_medical, DROP docs_driving_license');
    }
}
