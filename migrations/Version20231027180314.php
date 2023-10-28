<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231027180314 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE result_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE result (id INT NOT NULL, regon VARCHAR(255) NOT NULL, regon14 VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, province VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, community VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, silo INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE result_id_seq CASCADE');
        $this->addSql('DROP TABLE result');
    }
}
