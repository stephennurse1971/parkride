<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230911160118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facebook_groups_reviews (id INT AUTO_INCREMENT NOT NULL, facebook_group_id INT DEFAULT NULL, reviewer_id INT DEFAULT NULL, date DATETIME DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_7213075C39F54AEF (facebook_group_id), INDEX IDX_7213075C70574616 (reviewer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facebook_groups_reviews ADD CONSTRAINT FK_7213075C39F54AEF FOREIGN KEY (facebook_group_id) REFERENCES facebook_groups (id)');
        $this->addSql('ALTER TABLE facebook_groups_reviews ADD CONSTRAINT FK_7213075C70574616 FOREIGN KEY (reviewer_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE facebook_groups_reviews');
    }
}
