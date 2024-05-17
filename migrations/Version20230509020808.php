<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509020808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE yellow_pink_slips (id INT AUTO_INCREMENT NOT NULL, recipient_id INT DEFAULT NULL, checked_by_id INT DEFAULT NULL, colour VARCHAR(255) DEFAULT NULL, issue_date DATE DEFAULT NULL, checked TINYINT(1) DEFAULT NULL, INDEX IDX_65378EDBE92F8F78 (recipient_id), INDEX IDX_65378EDB2199DB86 (checked_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE yellow_pink_slips ADD CONSTRAINT FK_65378EDBE92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE yellow_pink_slips ADD CONSTRAINT FK_65378EDB2199DB86 FOREIGN KEY (checked_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE yellow_pink_slips');
    }
}
