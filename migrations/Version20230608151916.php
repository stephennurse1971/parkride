<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230608151916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE office_appointments (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, staff_id INT DEFAULT NULL, date DATE DEFAULT NULL, time TIME DEFAULT NULL, INDEX IDX_4F144A9819EB6921 (client_id), INDEX IDX_4F144A98D4D57CD (staff_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE office_appointments ADD CONSTRAINT FK_4F144A9819EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE office_appointments ADD CONSTRAINT FK_4F144A98D4D57CD FOREIGN KEY (staff_id) REFERENCES user (id)');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE office_appointments');
        $this->addSql('ALTER TABLE business_contacts DROP FOREIGN KEY FK_3B701BE5987F37DE');
        $this->addSql('DROP INDEX IDX_3B701BE5987F37DE ON business_contacts');
    }
}
