<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200218101024 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('INSERT INTO sortirpointcom.ville (id, nom, code_postal) VALUES (1, \'Rennes\', \'35000\')');
        $this->addSql('INSERT INTO sortirpointcom.ville (id, nom, code_postal) VALUES (2, \'Brest\', \'29000\')');
        $this->addSql('INSERT INTO sortirpointcom.ville (id, nom, code_postal) VALUES (3, \'Niort\', \'44000\')');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
