<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250421172459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD date_planification TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD type VARCHAR(20) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD nombre_tickets_planifie INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD nombre_tickets_vendus INT NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP date_planification
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP type
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP nombre_tickets_planifie
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP nombre_tickets_vendus
        SQL);
    }
}
