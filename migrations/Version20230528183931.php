<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528183931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE players (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, balance INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE stats (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, hands INTEGER NOT NULL, wins INTEGER DEFAULT NULL, ties INTEGER DEFAULT NULL, totalbet INTEGER NOT NULL, totalreturn INTEGER DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE players');
        $this->addSql('DROP TABLE stats');
    }
}
