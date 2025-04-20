<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250420154454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ligne_arret (ligne_id INT NOT NULL, arret_id INT NOT NULL, PRIMARY KEY(ligne_id, arret_id))');
        $this->addSql('CREATE INDEX IDX_B87DBD3E5A438E76 ON ligne_arret (ligne_id)');
        $this->addSql('CREATE INDEX IDX_B87DBD3E68F1C150 ON ligne_arret (arret_id)');
        $this->addSql('ALTER TABLE ligne_arret ADD CONSTRAINT FK_B87DBD3E5A438E76 FOREIGN KEY (ligne_id) REFERENCES ligne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_arret ADD CONSTRAINT FK_B87DBD3E68F1C150 FOREIGN KEY (arret_id) REFERENCES arret (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE arret DROP CONSTRAINT fk_bbd1570e5a438e76');
        $this->addSql('DROP INDEX idx_bbd1570e5a438e76');
        $this->addSql('ALTER TABLE arret DROP ligne_id');
        $this->addSql('ALTER TABLE conducteur ALTER disponible DROP DEFAULT');
        $this->addSql('ALTER TABLE conducteur ALTER disponible SET NOT NULL');
        $this->addSql('ALTER TABLE ligne ADD station_depart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne ADD station_arrivee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne ADD CONSTRAINT FK_57F0DB832C869050 FOREIGN KEY (station_depart_id) REFERENCES station (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne ADD CONSTRAINT FK_57F0DB83601733C0 FOREIGN KEY (station_arrivee_id) REFERENCES station (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_57F0DB832C869050 ON ligne (station_depart_id)');
        $this->addSql('CREATE INDEX IDX_57F0DB83601733C0 ON ligne (station_arrivee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ligne_arret DROP CONSTRAINT FK_B87DBD3E5A438E76');
        $this->addSql('ALTER TABLE ligne_arret DROP CONSTRAINT FK_B87DBD3E68F1C150');
        $this->addSql('DROP TABLE ligne_arret');
        $this->addSql('ALTER TABLE ligne DROP CONSTRAINT FK_57F0DB832C869050');
        $this->addSql('ALTER TABLE ligne DROP CONSTRAINT FK_57F0DB83601733C0');
        $this->addSql('DROP INDEX IDX_57F0DB832C869050');
        $this->addSql('DROP INDEX IDX_57F0DB83601733C0');
        $this->addSql('ALTER TABLE ligne DROP station_depart_id');
        $this->addSql('ALTER TABLE ligne DROP station_arrivee_id');
        $this->addSql('ALTER TABLE arret ADD ligne_id INT NOT NULL');
        $this->addSql('ALTER TABLE arret ADD CONSTRAINT fk_bbd1570e5a438e76 FOREIGN KEY (ligne_id) REFERENCES ligne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_bbd1570e5a438e76 ON arret (ligne_id)');
        $this->addSql('ALTER TABLE conducteur ALTER disponible SET DEFAULT true');
        $this->addSql('ALTER TABLE conducteur ALTER disponible DROP NOT NULL');
    }
}
