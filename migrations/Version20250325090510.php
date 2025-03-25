<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325090510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE arret_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE bus_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE conducteur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE panne_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE station_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ticket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE trajet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE arret (id INT NOT NULL, ligne_id INT NOT NULL, nom VARCHAR(255) NOT NULL, numero INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BBD1570E5A438E76 ON arret (ligne_id)');
        $this->addSql('CREATE TABLE bus (id INT NOT NULL, conducteur_id INT NOT NULL, immatriculation VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, kilometrage INT NOT NULL, nbre_places INT NOT NULL, en_circulation BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2F566B69F16F4AC6 ON bus (conducteur_id)');
        $this->addSql('CREATE TABLE conducteur (id INT NOT NULL, matricule VARCHAR(50) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, telephone VARCHAR(20) NOT NULL, type_permis VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2367714312B2DC9C ON conducteur (matricule)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23677143450FF010 ON conducteur (telephone)');
        $this->addSql('CREATE TABLE ligne (id INT NOT NULL, nbr_kilometre INT NOT NULL, tarif NUMERIC(10, 2) NOT NULL, etat VARCHAR(50) NOT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE panne (id INT NOT NULL, bus_id INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, description VARCHAR(255) NOT NULL, is_etat BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3885B2602546731D ON panne (bus_id)');
        $this->addSql('CREATE TABLE station (id INT NOT NULL, numero INT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ticket (id INT NOT NULL, trajet_id INT NOT NULL, prix NUMERIC(10, 2) NOT NULL, date_vente TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, etat VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_97A0ADA3D12A823 ON ticket (trajet_id)');
        $this->addSql('CREATE TABLE trajet (id INT NOT NULL, ligne_id INT NOT NULL, type VARCHAR(100) NOT NULL, nbr_ticket INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2B5BA98C5A438E76 ON trajet (ligne_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('ALTER TABLE arret ADD CONSTRAINT FK_BBD1570E5A438E76 FOREIGN KEY (ligne_id) REFERENCES ligne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bus ADD CONSTRAINT FK_2F566B69F16F4AC6 FOREIGN KEY (conducteur_id) REFERENCES conducteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE panne ADD CONSTRAINT FK_3885B2602546731D FOREIGN KEY (bus_id) REFERENCES bus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C5A438E76 FOREIGN KEY (ligne_id) REFERENCES ligne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE arret_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE bus_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE conducteur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE panne_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE station_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ticket_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE trajet_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE arret DROP CONSTRAINT FK_BBD1570E5A438E76');
        $this->addSql('ALTER TABLE bus DROP CONSTRAINT FK_2F566B69F16F4AC6');
        $this->addSql('ALTER TABLE panne DROP CONSTRAINT FK_3885B2602546731D');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3D12A823');
        $this->addSql('ALTER TABLE trajet DROP CONSTRAINT FK_2B5BA98C5A438E76');
        $this->addSql('DROP TABLE arret');
        $this->addSql('DROP TABLE bus');
        $this->addSql('DROP TABLE conducteur');
        $this->addSql('DROP TABLE ligne');
        $this->addSql('DROP TABLE panne');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE "user"');
    }
}
