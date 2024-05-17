<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230813133603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE referrals (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, business_site_id INT DEFAULT NULL, date_time DATE DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, INDEX IDX_1B7DC896A76ED395 (user_id), INDEX IDX_1B7DC896AB8EAD0B (business_site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE referrals ADD CONSTRAINT FK_1B7DC896A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE referrals ADD CONSTRAINT FK_1B7DC896AB8EAD0B FOREIGN KEY (business_site_id) REFERENCES business_contacts (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE referrals');
    }
}
