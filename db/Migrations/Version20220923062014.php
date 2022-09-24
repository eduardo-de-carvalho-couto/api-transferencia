<?php

declare(strict_types=1);

namespace Api\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923062014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__pessoas AS SELECT id, nome, email, senha, cpf FROM pessoas');
        $this->addSql('DROP TABLE pessoas');
        $this->addSql('CREATE TABLE pessoas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(45) NOT NULL, email EMAIL NOT NULL, senha VARCHAR(19) DEFAULT NULL, cpf CPF NOT NULL)');
        $this->addSql('INSERT INTO pessoas (id, nome, email, senha, cpf) SELECT id, nome, email, senha, cpf FROM __temp__pessoas');
        $this->addSql('DROP TABLE __temp__pessoas');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__pessoas AS SELECT id, nome, email, senha, cpf FROM pessoas');
        $this->addSql('DROP TABLE pessoas');
        $this->addSql('CREATE TABLE pessoas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(45) NOT NULL, email EMAIL NOT NULL, senha VARCHAR(19) DEFAULT NULL, cpf VARCHAR(15) NOT NULL)');
        $this->addSql('INSERT INTO pessoas (id, nome, email, senha, cpf) SELECT id, nome, email, senha, cpf FROM __temp__pessoas');
        $this->addSql('DROP TABLE __temp__pessoas');
    }
}
