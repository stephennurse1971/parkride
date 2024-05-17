<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829111655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE document_history ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE document_history ADD CONSTRAINT FK_83D5D69719EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_83D5D69719EB6921 ON document_history (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
       // $this->addSql('CREATE TABLE transaction_history (id INT AUTO_INCREMENT NOT NULL, edited_by_id INT DEFAULT NULL, notes JSON DEFAULT NULL, document VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, document_id INT NOT NULL, date DATETIME DEFAULT NULL, INDEX IDX_51104CA9DD7B2EBC (edited_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE transaction_history ADD CONSTRAINT FK_51104CA9DD7B2EBC FOREIGN KEY (edited_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE document_history DROP FOREIGN KEY FK_83D5D69719EB6921');
        $this->addSql('DROP INDEX IDX_83D5D69719EB6921 ON document_history');
        $this->addSql('ALTER TABLE document_history DROP client_id');
    }
}
