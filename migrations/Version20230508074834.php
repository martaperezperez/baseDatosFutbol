<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508074834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, dni VARCHAR(11) NOT NULL, name VARCHAR(20) NOT NULL, last_name VARCHAR(40) NOT NULL, team VARCHAR(255) NOT NULL, salary DOUBLE PRECISION NOT NULL, position VARCHAR(20) NOT NULL, dorsal INT NOT NULL, email VARCHAR(255) NOT NULL, phone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE jugador');
        $this->addSql('ALTER TABLE club ADD phone VARCHAR(255) NOT NULL, DROP telefono, CHANGE nombre name VARCHAR(255) NOT NULL, CHANGE presupuesto budget DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE entrenador CHANGE nombre name VARCHAR(20) NOT NULL, CHANGE apellidos last_name VARCHAR(40) NOT NULL, CHANGE equipo team VARCHAR(255) NOT NULL, CHANGE salario salary DOUBLE PRECISION NOT NULL, CHANGE telefono phone INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jugador (id INT AUTO_INCREMENT NOT NULL, dni VARCHAR(11) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nombre VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, apellidos VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, equipo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, salario DOUBLE PRECISION NOT NULL, posicion VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dorsal INT NOT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, telefono INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE player');
        $this->addSql('ALTER TABLE club ADD nombre VARCHAR(255) NOT NULL, ADD telefono INT NOT NULL, DROP name, DROP phone, CHANGE budget presupuesto DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE entrenador CHANGE name nombre VARCHAR(20) NOT NULL, CHANGE last_name apellidos VARCHAR(40) NOT NULL, CHANGE team equipo VARCHAR(255) NOT NULL, CHANGE salary salario DOUBLE PRECISION NOT NULL, CHANGE phone telefono INT NOT NULL');
    }
}
