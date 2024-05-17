<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508180303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE immigration_appointments (id INT AUTO_INCREMENT NOT NULL, chaperone_id INT DEFAULT NULL, client_id INT DEFAULT NULL, date_time DATETIME DEFAULT NULL, INDEX IDX_8AFBE721A92CA31C (chaperone_id), INDEX IDX_8AFBE72119EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE immigration_appointments ADD CONSTRAINT FK_8AFBE721A92CA31C FOREIGN KEY (chaperone_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE immigration_appointments ADD CONSTRAINT FK_8AFBE72119EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE immigration_appointments');
    }
}
