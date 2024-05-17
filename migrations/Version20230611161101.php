<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230611161101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emails (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, recipient_name VARCHAR(255) DEFAULT NULL, recipient_email VARCHAR(255) DEFAULT NULL, date_time DATETIME DEFAULT NULL, sender VARCHAR(255) DEFAULT NULL, subject VARCHAR(255) DEFAULT NULL, body LONGTEXT DEFAULT NULL, INDEX IDX_4C81E85219EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emails ADD CONSTRAINT FK_4C81E85219EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE emails');
    }
}
