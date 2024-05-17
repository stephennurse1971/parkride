<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529051734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tenancy_agreements (id INT AUTO_INCREMENT NOT NULL, tenant_id INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, signed_by_mukhtar TINYINT(1) DEFAULT NULL, rent_amount DOUBLE PRECISION DEFAULT NULL, INDEX IDX_A2E50AEE9033212A (tenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tenancy_agreements_user (tenancy_agreements_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1BF7F3A8EFB2C645 (tenancy_agreements_id), INDEX IDX_1BF7F3A8A76ED395 (user_id), PRIMARY KEY(tenancy_agreements_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tenancy_agreements ADD CONSTRAINT FK_A2E50AEE9033212A FOREIGN KEY (tenant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tenancy_agreements_user ADD CONSTRAINT FK_1BF7F3A8EFB2C645 FOREIGN KEY (tenancy_agreements_id) REFERENCES tenancy_agreements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tenancy_agreements_user ADD CONSTRAINT FK_1BF7F3A8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tenancy_agreements_user DROP FOREIGN KEY FK_1BF7F3A8EFB2C645');
        $this->addSql('DROP TABLE tenancy_agreements');
        $this->addSql('DROP TABLE tenancy_agreements_user');
    }
}
