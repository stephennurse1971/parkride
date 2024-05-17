<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109074122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE birth_death_marriage_certificates_documentation_errors DROP FOREIGN KEY FK_37A7DBCA792C519');
        $this->addSql('ALTER TABLE criminal_record_check DROP FOREIGN KEY FK_4317033BF92F3E70');
        $this->addSql('ALTER TABLE driving_license DROP FOREIGN KEY FK_CC361A336B421914');
        $this->addSql('ALTER TABLE employment_contracts DROP FOREIGN KEY FK_BFC955A5F92F3E70');
        $this->addSql('ALTER TABLE passports DROP FOREIGN KEY FK_1560E557F92F3E70');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64981B2B6EE');
        $this->addSql('ALTER TABLE criminal_record_check_documentation_errors DROP FOREIGN KEY FK_F0559856E6811906');
        $this->addSql('ALTER TABLE financial_statements DROP FOREIGN KEY FK_27CA307A38248176');
        $this->addSql('ALTER TABLE driving_license_documentation_errors DROP FOREIGN KEY FK_64AF63543FFBF177');
        $this->addSql('ALTER TABLE employment_contracts_documentation_errors DROP FOREIGN KEY FK_200C9F689C868901');
        $this->addSql('ALTER TABLE financial_statements_documentation_errors DROP FOREIGN KEY FK_D1EE60C69BD035CC');
        $this->addSql('ALTER TABLE health_insurance_documentation_errors DROP FOREIGN KEY FK_27BBD96366591349');
        $this->addSql('ALTER TABLE medical_documentation_errors DROP FOREIGN KEY FK_DD68F89592AF3BA');
        $this->addSql('ALTER TABLE passports_documentation_errors DROP FOREIGN KEY FK_CC036AD661099BE1');
        $this->addSql('ALTER TABLE school_attendance_certificates_documentation_errors DROP FOREIGN KEY FK_53C6A37BA80BBFC2');
        $this->addSql('ALTER TABLE tenancy_agreements_documentation_errors DROP FOREIGN KEY FK_38E5D79EEFB2C645');
        $this->addSql('ALTER TABLE tenancy_agreements_user DROP FOREIGN KEY FK_1BF7F3A8EFB2C645');
        $this->addSql('ALTER TABLE utility_bills_documentation_errors DROP FOREIGN KEY FK_7E1C127C604F3689');
        $this->addSql('DROP TABLE birth_death_marriage_certificates');
        $this->addSql('DROP TABLE birth_death_marriage_certificates_documentation_errors');
        $this->addSql('DROP TABLE car_manufacturers');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE criminal_record_check');
        $this->addSql('DROP TABLE criminal_record_check_documentation_errors');
        $this->addSql('DROP TABLE currencies');
        $this->addSql('DROP TABLE driving_license');
        $this->addSql('DROP TABLE driving_license_documentation_errors');
        $this->addSql('DROP TABLE employment_contracts');
        $this->addSql('DROP TABLE employment_contracts_documentation_errors');
        $this->addSql('DROP TABLE financial_statements');
        $this->addSql('DROP TABLE financial_statements_documentation_errors');
        $this->addSql('DROP TABLE health_insurance');
        $this->addSql('DROP TABLE health_insurance_documentation_errors');
        $this->addSql('DROP TABLE medical');
        $this->addSql('DROP TABLE medical_documentation_errors');
        $this->addSql('DROP TABLE passports');
        $this->addSql('DROP TABLE passports_documentation_errors');
        $this->addSql('DROP TABLE school_attendance_certificates');
        $this->addSql('DROP TABLE school_attendance_certificates_documentation_errors');
        $this->addSql('DROP TABLE tenancy_agreements');
        $this->addSql('DROP TABLE tenancy_agreements_documentation_errors');
        $this->addSql('DROP TABLE tenancy_agreements_user');
        $this->addSql('DROP TABLE utility_bills');
        $this->addSql('DROP TABLE utility_bills_documentation_errors');
        $this->addSql('DROP TABLE yellow_pink_slips');
        $this->addSql('DROP INDEX IDX_8D93D64981B2B6EE ON user');
        $this->addSql('ALTER TABLE user DROP address_country_id, DROP gender, DROP official_form_display_language');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE birth_death_marriage_certificates (id INT AUTO_INCREMENT NOT NULL, applicant_id INT DEFAULT NULL, reviewed_by_id INT DEFAULT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, certificate_file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, relative VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed_date DATE DEFAULT NULL, comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_ED495B29FC6B21F1 (reviewed_by_id), INDEX IDX_ED495B2997139001 (applicant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE birth_death_marriage_certificates_documentation_errors (birth_death_marriage_certificates_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_37A7DBCA792C519 (birth_death_marriage_certificates_id), INDEX IDX_37A7DBCAF9B0C471 (documentation_errors_id), PRIMARY KEY(birth_death_marriage_certificates_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE car_manufacturers (id INT AUTO_INCREMENT NOT NULL, manufacturer VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, is_eu TINYINT(1) DEFAULT NULL, ranking INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE criminal_record_check (id INT AUTO_INCREMENT NOT NULL, applicant_id INT DEFAULT NULL, country_id INT DEFAULT NULL, reviewed_by_id INT DEFAULT NULL, date DATE DEFAULT NULL, convictions TINYINT(1) DEFAULT NULL, convictions_commentary VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed_date DATE DEFAULT NULL, comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_4317033BF92F3E70 (country_id), INDEX IDX_4317033B97139001 (applicant_id), INDEX IDX_4317033BFC6B21F1 (reviewed_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE criminal_record_check_documentation_errors (criminal_record_check_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_F0559856E6811906 (criminal_record_check_id), INDEX IDX_F0559856F9B0C471 (documentation_errors_id), PRIMARY KEY(criminal_record_check_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE currencies (id INT AUTO_INCREMENT NOT NULL, currency VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, fx_rate DOUBLE PRECISION DEFAULT NULL, ranking INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE driving_license (id INT AUTO_INCREMENT NOT NULL, driving_license_holder_id INT DEFAULT NULL, driving_license_country_id INT DEFAULT NULL, reviewed_by_id INT DEFAULT NULL, license_number VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, issue_date DATE DEFAULT NULL, expiry_date DATE DEFAULT NULL, codes VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, last_name_on_license VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, first_name_on_license VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, license_scan1 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, license_scan2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed_date DATE DEFAULT NULL, comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_CC361A336B421914 (driving_license_country_id), INDEX IDX_CC361A3361479D1C (driving_license_holder_id), INDEX IDX_CC361A33FC6B21F1 (reviewed_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE driving_license_documentation_errors (driving_license_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_64AF63543FFBF177 (driving_license_id), INDEX IDX_64AF6354F9B0C471 (documentation_errors_id), PRIMARY KEY(driving_license_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE employment_contracts (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, country_id INT DEFAULT NULL, reviewed_by_id INT DEFAULT NULL, employer VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, salary_per_month DOUBLE PRECISION DEFAULT NULL, file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, start_date DATE DEFAULT NULL, tenure VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed_date DATE DEFAULT NULL, comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_BFC955A5F92F3E70 (country_id), INDEX IDX_BFC955A58C03F15C (employee_id), INDEX IDX_BFC955A5FC6B21F1 (reviewed_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE employment_contracts_documentation_errors (employment_contracts_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_200C9F689C868901 (employment_contracts_id), INDEX IDX_200C9F68F9B0C471 (documentation_errors_id), PRIMARY KEY(employment_contracts_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE financial_statements (id INT AUTO_INCREMENT NOT NULL, account_holder_id INT DEFAULT NULL, currency_id INT DEFAULT NULL, reviewed_by_id INT DEFAULT NULL, bank VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date DATE DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed_date DATE DEFAULT NULL, comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_27CA307A38248176 (currency_id), INDEX IDX_27CA307AFC94BA8B (account_holder_id), INDEX IDX_27CA307AFC6B21F1 (reviewed_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE financial_statements_documentation_errors (financial_statements_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_D1EE60C69BD035CC (financial_statements_id), INDEX IDX_D1EE60C6F9B0C471 (documentation_errors_id), PRIMARY KEY(financial_statements_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE health_insurance (id INT AUTO_INCREMENT NOT NULL, applicant_id INT DEFAULT NULL, reviewed_by_id INT DEFAULT NULL, date DATE DEFAULT NULL, insurance_provider VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed_date DATE DEFAULT NULL, comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_558804DEFC6B21F1 (reviewed_by_id), INDEX IDX_558804DE97139001 (applicant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE health_insurance_documentation_errors (health_insurance_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_27BBD96366591349 (health_insurance_id), INDEX IDX_27BBD963F9B0C471 (documentation_errors_id), PRIMARY KEY(health_insurance_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE medical (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, reviewed_by_id INT DEFAULT NULL, date DATE DEFAULT NULL, relevant_conditions VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed_date DATE DEFAULT NULL, comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_77DB075AFC6B21F1 (reviewed_by_id), INDEX IDX_77DB075A6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE medical_documentation_errors (medical_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_DD68F89592AF3BA (medical_id), INDEX IDX_DD68F89F9B0C471 (documentation_errors_id), PRIMARY KEY(medical_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE passports (id INT AUTO_INCREMENT NOT NULL, passport_holder_id INT NOT NULL, country_id INT DEFAULT NULL, reviewed_by_id INT DEFAULT NULL, issue_date DATE DEFAULT NULL, expiry_date DATE DEFAULT NULL, passport_number VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, place_of_birth VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, passport_scan1 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, passport_scan2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed_date DATE DEFAULT NULL, comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1560E557F92F3E70 (country_id), INDEX IDX_1560E5578E2159F9 (passport_holder_id), INDEX IDX_1560E557FC6B21F1 (reviewed_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE passports_documentation_errors (passports_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_CC036AD661099BE1 (passports_id), INDEX IDX_CC036AD6F9B0C471 (documentation_errors_id), PRIMARY KEY(passports_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE school_attendance_certificates (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, reviewed_by_id INT DEFAULT NULL, school VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date DATE DEFAULT NULL, file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed_date DATE DEFAULT NULL, comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_58CE2EFBFC6B21F1 (reviewed_by_id), INDEX IDX_58CE2EFBCB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE school_attendance_certificates_documentation_errors (school_attendance_certificates_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_53C6A37BA80BBFC2 (school_attendance_certificates_id), INDEX IDX_53C6A37BF9B0C471 (documentation_errors_id), PRIMARY KEY(school_attendance_certificates_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tenancy_agreements (id INT AUTO_INCREMENT NOT NULL, tenant_id INT DEFAULT NULL, reviewed_by_id INT DEFAULT NULL, address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, signed_by_mukhtar TINYINT(1) DEFAULT NULL, rent_amount DOUBLE PRECISION DEFAULT NULL, file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed_date DATE DEFAULT NULL, comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_A2E50AEEFC6B21F1 (reviewed_by_id), INDEX IDX_A2E50AEE9033212A (tenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tenancy_agreements_documentation_errors (tenancy_agreements_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_38E5D79EEFB2C645 (tenancy_agreements_id), INDEX IDX_38E5D79EF9B0C471 (documentation_errors_id), PRIMARY KEY(tenancy_agreements_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tenancy_agreements_user (tenancy_agreements_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1BF7F3A8EFB2C645 (tenancy_agreements_id), INDEX IDX_1BF7F3A8A76ED395 (user_id), PRIMARY KEY(tenancy_agreements_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utility_bills (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, reviewed_by_id INT DEFAULT NULL, address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date DATE DEFAULT NULL, utility_provider VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reviewed_date DATE DEFAULT NULL, comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D706525FFC6B21F1 (reviewed_by_id), INDEX IDX_D706525F9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utility_bills_documentation_errors (utility_bills_id INT NOT NULL, documentation_errors_id INT NOT NULL, INDEX IDX_7E1C127C604F3689 (utility_bills_id), INDEX IDX_7E1C127CF9B0C471 (documentation_errors_id), PRIMARY KEY(utility_bills_id, documentation_errors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE yellow_pink_slips (id INT AUTO_INCREMENT NOT NULL, recipient_id INT DEFAULT NULL, checked_by_id INT DEFAULT NULL, colour VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, issue_date DATE DEFAULT NULL, checked TINYINT(1) DEFAULT NULL, file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_65378EDB2199DB86 (checked_by_id), INDEX IDX_65378EDBE92F8F78 (recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE birth_death_marriage_certificates ADD CONSTRAINT FK_ED495B2997139001 FOREIGN KEY (applicant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE birth_death_marriage_certificates ADD CONSTRAINT FK_ED495B29FC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE birth_death_marriage_certificates_documentation_errors ADD CONSTRAINT FK_37A7DBCA792C519 FOREIGN KEY (birth_death_marriage_certificates_id) REFERENCES birth_death_marriage_certificates (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE birth_death_marriage_certificates_documentation_errors ADD CONSTRAINT FK_37A7DBCAF9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE criminal_record_check ADD CONSTRAINT FK_4317033B97139001 FOREIGN KEY (applicant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE criminal_record_check ADD CONSTRAINT FK_4317033BF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE criminal_record_check ADD CONSTRAINT FK_4317033BFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE criminal_record_check_documentation_errors ADD CONSTRAINT FK_F0559856E6811906 FOREIGN KEY (criminal_record_check_id) REFERENCES criminal_record_check (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE criminal_record_check_documentation_errors ADD CONSTRAINT FK_F0559856F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE driving_license ADD CONSTRAINT FK_CC361A3361479D1C FOREIGN KEY (driving_license_holder_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE driving_license ADD CONSTRAINT FK_CC361A336B421914 FOREIGN KEY (driving_license_country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE driving_license ADD CONSTRAINT FK_CC361A33FC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE driving_license_documentation_errors ADD CONSTRAINT FK_64AF63543FFBF177 FOREIGN KEY (driving_license_id) REFERENCES driving_license (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE driving_license_documentation_errors ADD CONSTRAINT FK_64AF6354F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employment_contracts ADD CONSTRAINT FK_BFC955A58C03F15C FOREIGN KEY (employee_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employment_contracts ADD CONSTRAINT FK_BFC955A5F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE employment_contracts ADD CONSTRAINT FK_BFC955A5FC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employment_contracts_documentation_errors ADD CONSTRAINT FK_200C9F689C868901 FOREIGN KEY (employment_contracts_id) REFERENCES employment_contracts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employment_contracts_documentation_errors ADD CONSTRAINT FK_200C9F68F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE financial_statements ADD CONSTRAINT FK_27CA307A38248176 FOREIGN KEY (currency_id) REFERENCES currencies (id)');
        $this->addSql('ALTER TABLE financial_statements ADD CONSTRAINT FK_27CA307AFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE financial_statements ADD CONSTRAINT FK_27CA307AFC94BA8B FOREIGN KEY (account_holder_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE financial_statements_documentation_errors ADD CONSTRAINT FK_D1EE60C69BD035CC FOREIGN KEY (financial_statements_id) REFERENCES financial_statements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE financial_statements_documentation_errors ADD CONSTRAINT FK_D1EE60C6F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE health_insurance ADD CONSTRAINT FK_558804DE97139001 FOREIGN KEY (applicant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE health_insurance ADD CONSTRAINT FK_558804DEFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE health_insurance_documentation_errors ADD CONSTRAINT FK_27BBD96366591349 FOREIGN KEY (health_insurance_id) REFERENCES health_insurance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE health_insurance_documentation_errors ADD CONSTRAINT FK_27BBD963F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medical ADD CONSTRAINT FK_77DB075A6B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE medical ADD CONSTRAINT FK_77DB075AFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE medical_documentation_errors ADD CONSTRAINT FK_DD68F89592AF3BA FOREIGN KEY (medical_id) REFERENCES medical (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medical_documentation_errors ADD CONSTRAINT FK_DD68F89F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE passports ADD CONSTRAINT FK_1560E5578E2159F9 FOREIGN KEY (passport_holder_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE passports ADD CONSTRAINT FK_1560E557F92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE passports ADD CONSTRAINT FK_1560E557FC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE passports_documentation_errors ADD CONSTRAINT FK_CC036AD661099BE1 FOREIGN KEY (passports_id) REFERENCES passports (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE passports_documentation_errors ADD CONSTRAINT FK_CC036AD6F9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE school_attendance_certificates ADD CONSTRAINT FK_58CE2EFBCB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE school_attendance_certificates ADD CONSTRAINT FK_58CE2EFBFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE school_attendance_certificates_documentation_errors ADD CONSTRAINT FK_53C6A37BA80BBFC2 FOREIGN KEY (school_attendance_certificates_id) REFERENCES school_attendance_certificates (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE school_attendance_certificates_documentation_errors ADD CONSTRAINT FK_53C6A37BF9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tenancy_agreements ADD CONSTRAINT FK_A2E50AEE9033212A FOREIGN KEY (tenant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tenancy_agreements ADD CONSTRAINT FK_A2E50AEEFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tenancy_agreements_documentation_errors ADD CONSTRAINT FK_38E5D79EEFB2C645 FOREIGN KEY (tenancy_agreements_id) REFERENCES tenancy_agreements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tenancy_agreements_documentation_errors ADD CONSTRAINT FK_38E5D79EF9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tenancy_agreements_user ADD CONSTRAINT FK_1BF7F3A8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tenancy_agreements_user ADD CONSTRAINT FK_1BF7F3A8EFB2C645 FOREIGN KEY (tenancy_agreements_id) REFERENCES tenancy_agreements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utility_bills ADD CONSTRAINT FK_D706525F9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE utility_bills ADD CONSTRAINT FK_D706525FFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE utility_bills_documentation_errors ADD CONSTRAINT FK_7E1C127C604F3689 FOREIGN KEY (utility_bills_id) REFERENCES utility_bills (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utility_bills_documentation_errors ADD CONSTRAINT FK_7E1C127CF9B0C471 FOREIGN KEY (documentation_errors_id) REFERENCES documentation_errors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE yellow_pink_slips ADD CONSTRAINT FK_65378EDB2199DB86 FOREIGN KEY (checked_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE yellow_pink_slips ADD CONSTRAINT FK_65378EDBE92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD address_country_id INT DEFAULT NULL, ADD gender VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD official_form_display_language VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64981B2B6EE FOREIGN KEY (address_country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64981B2B6EE ON user (address_country_id)');
    }
}
