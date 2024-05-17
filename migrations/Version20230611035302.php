<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230611035302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE criminal_record_check ADD reviewed_by_id INT DEFAULT NULL, ADD reviewed VARCHAR(255) DEFAULT NULL, ADD reviewed_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE criminal_record_check ADD CONSTRAINT FK_4317033BFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4317033BFC6B21F1 ON criminal_record_check (reviewed_by_id)');
        $this->addSql('ALTER TABLE driving_license ADD reviewed_by_id INT DEFAULT NULL, ADD reviewed VARCHAR(255) DEFAULT NULL, ADD reviewed_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE driving_license ADD CONSTRAINT FK_CC361A33FC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CC361A33FC6B21F1 ON driving_license (reviewed_by_id)');
        $this->addSql('ALTER TABLE financial_statements ADD reviewed_by_id INT DEFAULT NULL, ADD reviewed VARCHAR(255) DEFAULT NULL, ADD reviewed_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE financial_statements ADD CONSTRAINT FK_27CA307AFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_27CA307AFC6B21F1 ON financial_statements (reviewed_by_id)');
        $this->addSql('ALTER TABLE health_insurance ADD reviewed_by_id INT DEFAULT NULL, ADD reviewed VARCHAR(255) DEFAULT NULL, ADD reviewed_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE health_insurance ADD CONSTRAINT FK_558804DEFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_558804DEFC6B21F1 ON health_insurance (reviewed_by_id)');
        $this->addSql('ALTER TABLE medical ADD reviewed_by_id INT DEFAULT NULL, ADD reviewed VARCHAR(255) DEFAULT NULL, ADD reviewed_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE medical ADD CONSTRAINT FK_77DB075AFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_77DB075AFC6B21F1 ON medical (reviewed_by_id)');
        $this->addSql('ALTER TABLE school_attendance_certificates ADD reviewed_by_id INT DEFAULT NULL, ADD reviewed VARCHAR(255) DEFAULT NULL, ADD reviewed_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE school_attendance_certificates ADD CONSTRAINT FK_58CE2EFBFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_58CE2EFBFC6B21F1 ON school_attendance_certificates (reviewed_by_id)');
        $this->addSql('ALTER TABLE tenancy_agreements ADD reviewed_by_id INT DEFAULT NULL, ADD reviewed VARCHAR(255) DEFAULT NULL, ADD reviewed_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE tenancy_agreements ADD CONSTRAINT FK_A2E50AEEFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A2E50AEEFC6B21F1 ON tenancy_agreements (reviewed_by_id)');
        $this->addSql('ALTER TABLE utility_bills ADD reviewed_by_id INT DEFAULT NULL, ADD reviewed VARCHAR(255) DEFAULT NULL, ADD reviewed_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE utility_bills ADD CONSTRAINT FK_D706525FFC6B21F1 FOREIGN KEY (reviewed_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D706525FFC6B21F1 ON utility_bills (reviewed_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE criminal_record_check DROP FOREIGN KEY FK_4317033BFC6B21F1');
        $this->addSql('DROP INDEX IDX_4317033BFC6B21F1 ON criminal_record_check');
        $this->addSql('ALTER TABLE criminal_record_check DROP reviewed_by_id, DROP reviewed, DROP reviewed_date');
        $this->addSql('ALTER TABLE driving_license DROP FOREIGN KEY FK_CC361A33FC6B21F1');
        $this->addSql('DROP INDEX IDX_CC361A33FC6B21F1 ON driving_license');
        $this->addSql('ALTER TABLE driving_license DROP reviewed_by_id, DROP reviewed, DROP reviewed_date');
        $this->addSql('ALTER TABLE financial_statements DROP FOREIGN KEY FK_27CA307AFC6B21F1');
        $this->addSql('DROP INDEX IDX_27CA307AFC6B21F1 ON financial_statements');
        $this->addSql('ALTER TABLE financial_statements DROP reviewed_by_id, DROP reviewed, DROP reviewed_date');
        $this->addSql('ALTER TABLE health_insurance DROP FOREIGN KEY FK_558804DEFC6B21F1');
        $this->addSql('DROP INDEX IDX_558804DEFC6B21F1 ON health_insurance');
        $this->addSql('ALTER TABLE health_insurance DROP reviewed_by_id, DROP reviewed, DROP reviewed_date');
        $this->addSql('ALTER TABLE medical DROP FOREIGN KEY FK_77DB075AFC6B21F1');
        $this->addSql('DROP INDEX IDX_77DB075AFC6B21F1 ON medical');
        $this->addSql('ALTER TABLE medical DROP reviewed_by_id, DROP reviewed, DROP reviewed_date');
        $this->addSql('ALTER TABLE school_attendance_certificates DROP FOREIGN KEY FK_58CE2EFBFC6B21F1');
        $this->addSql('DROP INDEX IDX_58CE2EFBFC6B21F1 ON school_attendance_certificates');
        $this->addSql('ALTER TABLE school_attendance_certificates DROP reviewed_by_id, DROP reviewed, DROP reviewed_date');
        $this->addSql('ALTER TABLE tenancy_agreements DROP FOREIGN KEY FK_A2E50AEEFC6B21F1');
        $this->addSql('DROP INDEX IDX_A2E50AEEFC6B21F1 ON tenancy_agreements');
        $this->addSql('ALTER TABLE tenancy_agreements DROP reviewed_by_id, DROP reviewed, DROP reviewed_date');
        $this->addSql('ALTER TABLE utility_bills DROP FOREIGN KEY FK_D706525FFC6B21F1');
        $this->addSql('DROP INDEX IDX_D706525FFC6B21F1 ON utility_bills');
        $this->addSql('ALTER TABLE utility_bills DROP reviewed_by_id, DROP reviewed, DROP reviewed_date');
    }
}
