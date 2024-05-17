<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529113151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cms_dynamic (id INT AUTO_INCREMENT NOT NULL, web_page VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, title_fr VARCHAR(255) DEFAULT NULL, title_de VARCHAR(255) DEFAULT NULL, title_es VARCHAR(255) DEFAULT NULL, para1 VARCHAR(255) DEFAULT NULL, para1_fr VARCHAR(255) DEFAULT NULL, para1_de VARCHAR(255) DEFAULT NULL, para1_es VARCHAR(255) DEFAULT NULL, para2 LONGTEXT DEFAULT NULL, para2_fr LONGTEXT DEFAULT NULL, para2_de LONGTEXT DEFAULT NULL, para2_es LONGTEXT DEFAULT NULL, para3 LONGTEXT DEFAULT NULL, para3_fr LONGTEXT DEFAULT NULL, para3_de LONGTEXT DEFAULT NULL, para3_es LONGTEXT DEFAULT NULL, para4 LONGTEXT DEFAULT NULL, para4_fr LONGTEXT DEFAULT NULL, para4_de LONGTEXT DEFAULT NULL, para4_es LONGTEXT DEFAULT NULL, para5 LONGTEXT DEFAULT NULL, para5_fr LONGTEXT DEFAULT NULL, para5_de LONGTEXT DEFAULT NULL, para5_es LONGTEXT DEFAULT NULL, para6 LONGTEXT DEFAULT NULL, para6_fr LONGTEXT DEFAULT NULL, para6_de LONGTEXT DEFAULT NULL, para6_es LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cms_dynamic');
    }
}
