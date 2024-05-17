<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508171940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE financial_statements (id INT AUTO_INCREMENT NOT NULL, account_holder_id INT DEFAULT NULL, currency_id INT DEFAULT NULL, bank VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, INDEX IDX_27CA307AFC94BA8B (account_holder_id), INDEX IDX_27CA307A38248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE financial_statements ADD CONSTRAINT FK_27CA307AFC94BA8B FOREIGN KEY (account_holder_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE financial_statements ADD CONSTRAINT FK_27CA307A38248176 FOREIGN KEY (currency_id) REFERENCES currencies (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE financial_statements');
    }
}
