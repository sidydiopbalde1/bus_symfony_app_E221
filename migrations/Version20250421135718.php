<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250421135718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE ligne_arret (ligne_id INT NOT NULL, arret_id INT NOT NULL, PRIMARY KEY(ligne_id, arret_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B87DBD3E5A438E76 ON ligne_arret (ligne_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B87DBD3E68F1C150 ON ligne_arret (arret_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_arret ADD CONSTRAINT FK_B87DBD3E5A438E76 FOREIGN KEY (ligne_id) REFERENCES ligne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_arret ADD CONSTRAINT FK_B87DBD3E68F1C150 FOREIGN KEY (arret_id) REFERENCES arret (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panne ALTER bus_id SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP type
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet RENAME COLUMN nbr_ticket TO bus_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C2546731D FOREIGN KEY (bus_id) REFERENCES bus (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2B5BA98C2546731D ON trajet (bus_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_arret DROP CONSTRAINT FK_B87DBD3E5A438E76
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_arret DROP CONSTRAINT FK_B87DBD3E68F1C150
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ligne_arret
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panne ALTER bus_id DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP CONSTRAINT FK_2B5BA98C2546731D
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_2B5BA98C2546731D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD type VARCHAR(100) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet RENAME COLUMN bus_id TO nbr_ticket
        SQL);
    }
}
