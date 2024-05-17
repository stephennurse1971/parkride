<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230830073959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE birth_death_marriage_certificates_documentation_errors (birth_death_marriage_certificates_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_37A7DBCA792C519 (birth_death_marriage_certificates_id), INDEX IDX_37A7DBCAF9B0C471 (documentation_errors_id), PRIMARY KEY(birth_death_marriage_certificates_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE criminal_record_check_documentation_errors (criminal_record_check_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_F0559856E6811906 (criminal_record_check_id), INDEX IDX_F0559856F9B0C471 (documentation_errors_id), PRIMARY KEY(criminal_record_check_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE driving_license_documentation_errors (driving_license_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_64AF63543FFBF177 (driving_license_id), INDEX IDX_64AF6354F9B0C471 (documentation_errors_id), PRIMARY KEY(driving_license_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employment_contracts_documentation_errors (employment_contracts_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_200C9F689C868901 (employment_contracts_id), INDEX IDX_200C9F68F9B0C471 (documentation_errors_id), PRIMARY KEY(employment_contracts_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE financial_statements_documentation_errors (financial_statements_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_D1EE60C69BD035CC (financial_statements_id), INDEX IDX_D1EE60C6F9B0C471 (documentation_errors_id), PRIMARY KEY(financial_statements_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE health_insurance_documentation_errors (health_insurance_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_27BBD96366591349 (health_insurance_id), INDEX IDX_27BBD963F9B0C471 (documentation_errors_id), PRIMARY KEY(health_insurance_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_documentation_errors (medical_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_DD68F89592AF3BA (medical_id), INDEX IDX_DD68F89F9B0C471 (documentation_errors_id), PRIMARY KEY(medical_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school_attendance_certificate (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school_attendance_certificates_documentation_errors (school_attendance_certificates_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_53C6A37BA80BBFC2 (school_attendance_certificates_id), INDEX IDX_53C6A37BF9B0C471 (documentation_errors_id), PRIMARY KEY(school_attendance_certificates_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tenancy_agreements_documentation_errors (tenancy_agreements_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_38E5D79EEFB2C645 (tenancy_agreements_id), INDEX IDX_38E5D79EF9B0C471 (documentation_errors_id), PRIMARY KEY(tenancy_agreements_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utility_bills_documentation_errors (utility_bills_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_7E1C127C604F3689 (utility_bills_id), INDEX IDX_7E1C127CF9B0C471 (documentation_errors_id), PRIMARY KEY(utility_bills_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE birth_death_marriage_certificates_documentation_errors ADD CONSTRAINT FK_37A7DBCA792C519 FOREIGN KEY (birth_death_marriage_certificates_id) REFERENCES birth_death_marriage_certificates (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE birth_death_marriage_certificates_documentation_errors ADD CONSTRAINT FK_37A7DBCAF9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE criminal_record_check_documentation_errors ADD CONSTRAINT FK_F0559856E6811906 FOREIGN KEY (criminal_record_check_id) REFERENCES criminal_record_check (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE criminal_record_check_documentation_errors ADD CONSTRAINT FK_F0559856F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE driving_license_documentation_errors ADD CONSTRAINT FK_64AF63543FFBF177 FOREIGN KEY (driving_license_id) REFERENCES driving_license (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE driving_license_documentation_errors ADD CONSTRAINT FK_64AF6354F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employment_contracts_documentation_errors ADD CONSTRAINT FK_200C9F689C868901 FOREIGN KEY (employment_contracts_id) REFERENCES employment_contracts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employment_contracts_documentation_errors ADD CONSTRAINT FK_200C9F68F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE financial_statements_documentation_errors ADD CONSTRAINT FK_D1EE60C69BD035CC FOREIGN KEY (financial_statements_id) REFERENCES financial_statements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE financial_statements_documentation_errors ADD CONSTRAINT FK_D1EE60C6F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE health_insurance_documentation_errors ADD CONSTRAINT FK_27BBD96366591349 FOREIGN KEY (health_insurance_id) REFERENCES health_insurance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE health_insurance_documentation_errors ADD CONSTRAINT FK_27BBD963F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medical_documentation_errors ADD CONSTRAINT FK_DD68F89592AF3BA FOREIGN KEY (medical_id) REFERENCES medical (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medical_documentation_errors ADD CONSTRAINT FK_DD68F89F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE school_attendance_certificates_documentation_errors ADD CONSTRAINT FK_53C6A37BA80BBFC2 FOREIGN KEY (school_attendance_certificates_id) REFERENCES school_attendance_certificates (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE school_attendance_certificates_documentation_errors ADD CONSTRAINT FK_53C6A37BF9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tenancy_agreements_documentation_errors ADD CONSTRAINT FK_38E5D79EEFB2C645 FOREIGN KEY (tenancy_agreements_id) REFERENCES tenancy_agreements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tenancy_agreements_documentation_errors ADD CONSTRAINT FK_38E5D79EF9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utility_bills_documentation_errors ADD CONSTRAINT FK_7E1C127C604F3689 FOREIGN KEY (utility_bills_id) REFERENCES utility_bills (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utility_bills_documentation_errors ADD CONSTRAINT FK_7E1C127CF9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE birth_death_marriage_certificates_documentation_errors');
        $this->addSql('DROP TABLE criminal_record_check_documentation_errors');
        $this->addSql('DROP TABLE driving_license_documentation_errors');
        $this->addSql('DROP TABLE employment_contracts_documentation_errors');
        $this->addSql('DROP TABLE financial_statements_documentation_errors');
        $this->addSql('DROP TABLE health_insurance_documentation_errors');
        $this->addSql('DROP TABLE medical_documentation_errors');
        $this->addSql('DROP TABLE school_attendance_certificate');
        $this->addSql('DROP TABLE school_attendance_certificates_documentation_errors');
        $this->addSql('DROP TABLE tenancy_agreements_documentation_errors');
        $this->addSql('DROP TABLE utility_bills_documentation_errors');
    }
}
