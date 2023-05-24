<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230511131420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A6561190A32');
        $this->addSql('DROP INDEX IDX_98197A6561190A32 ON player');
        $this->addSql('ALTER TABLE player ADD club_id_id INT NOT NULL, ADD budget DOUBLE PRECISION NOT NULL, DROP club_id, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65DF2AB4E5 FOREIGN KEY (club_id_id) REFERENCES club (id)');
        $this->addSql('CREATE INDEX IDX_98197A65DF2AB4E5 ON player (club_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65DF2AB4E5');
        $this->addSql('DROP INDEX IDX_98197A65DF2AB4E5 ON player');
        $this->addSql('ALTER TABLE player ADD club_id INT DEFAULT NULL, DROP club_id_id, DROP budget, CHANGE name name VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A6561190A32 FOREIGN KEY (club_id) REFERENCES club (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_98197A6561190A32 ON player (club_id)');
    }
}
