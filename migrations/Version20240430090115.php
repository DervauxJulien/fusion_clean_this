<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430090115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation ADD user_id INT DEFAULT NULL, ADD tarif DOUBLE PRECISION NOT NULL, CHANGE description_client description_client LONGTEXT DEFAULT NULL, CHANGE img img VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(30) NOT NULL, CHANGE statut status VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1981A66DA76ED395 ON operation (user_id)');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(30) NOT NULL, CHANGE prenom prenom VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DA76ED395');
        $this->addSql('DROP INDEX IDX_1981A66DA76ED395 ON operation');
        $this->addSql('ALTER TABLE operation DROP user_id, DROP tarif, CHANGE description_client description_client LONGTEXT NOT NULL, CHANGE img img VARCHAR(255) NOT NULL, CHANGE type type VARCHAR(50) NOT NULL, CHANGE status statut VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL');
    }
}
