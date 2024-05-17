<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610120222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee_calendar_set_up ADD employee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employee_calendar_set_up ADD CONSTRAINT FK_166928C08C03F15C FOREIGN KEY (employee_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_166928C08C03F15C ON employee_calendar_set_up (employee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee_calendar_set_up DROP FOREIGN KEY FK_166928C08C03F15C');
        $this->addSql('DROP INDEX IDX_166928C08C03F15C ON employee_calendar_set_up');
        $this->addSql('ALTER TABLE employee_calendar_set_up DROP employee_id');
    }
}
