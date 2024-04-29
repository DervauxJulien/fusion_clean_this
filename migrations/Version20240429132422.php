<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429132422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, n_rue INT NOT NULL, nom_rue VARCHAR(255) NOT NULL, nom_ville VARCHAR(255) NOT NULL, cp INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, adresse_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_C74404554DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, operation_id INT DEFAULT NULL, prix_ht DOUBLE PRECISION NOT NULL, tva DOUBLE PRECISION NOT NULL, description VARCHAR(500) NOT NULL, date_creation DATE NOT NULL, INDEX IDX_FE86641019EB6921 (client_id), UNIQUE INDEX UNIQ_FE86641044AC3583 (operation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, adresse_id INT NOT NULL, client_id INT NOT NULL, description_op VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, description_client LONGTEXT NOT NULL, img VARCHAR(255) NOT NULL, validation_demande TINYINT(1) NOT NULL, type VARCHAR(50) NOT NULL, INDEX IDX_1981A66D4DE7DC5C (adresse_id), INDEX IDX_1981A66D19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, operation_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, INDEX IDX_8D93D64944AC3583 (operation_id), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404554DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641044AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64944AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404554DE7DC5C');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641019EB6921');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641044AC3583');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D4DE7DC5C');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D19EB6921');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64944AC3583');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
