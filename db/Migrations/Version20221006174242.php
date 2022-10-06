<?php

declare(strict_types=1);

namespace Api\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221006174242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lojas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(45) NOT NULL, email EMAIL NOT NULL, senha VARCHAR(200) DEFAULT NULL, cnpj VARCHAR(19) NOT NULL)');
        $this->addSql('CREATE TABLE pessoas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(45) NOT NULL, email EMAIL NOT NULL, senha VARCHAR(200) DEFAULT NULL, cpf CPF NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE lojas');
        $this->addSql('DROP TABLE pessoas');
    }
}
