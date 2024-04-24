<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424131153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demander (id INT AUTO_INCREMENT NOT NULL, discription_client VARCHAR(500) NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demander_operation (demander_id INT NOT NULL, operation_id INT NOT NULL, INDEX IDX_EFD9CF014C21AB48 (demander_id), INDEX IDX_EFD9CF0144AC3583 (operation_id), PRIMARY KEY(demander_id, operation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demander_client (demander_id INT NOT NULL, client_id INT NOT NULL, INDEX IDX_6CF32FFE4C21AB48 (demander_id), INDEX IDX_6CF32FFE19EB6921 (client_id), PRIMARY KEY(demander_id, client_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, prix_ht DOUBLE PRECISION NOT NULL, tva DOUBLE PRECISION NOT NULL, description VARCHAR(500) NOT NULL, date_creation DATE NOT NULL, INDEX IDX_FE86641019EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demander_operation ADD CONSTRAINT FK_EFD9CF014C21AB48 FOREIGN KEY (demander_id) REFERENCES demander (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demander_operation ADD CONSTRAINT FK_EFD9CF0144AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demander_client ADD CONSTRAINT FK_6CF32FFE4C21AB48 FOREIGN KEY (demander_id) REFERENCES demander (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demander_client ADD CONSTRAINT FK_6CF32FFE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demander_operation DROP FOREIGN KEY FK_EFD9CF014C21AB48');
        $this->addSql('ALTER TABLE demander_operation DROP FOREIGN KEY FK_EFD9CF0144AC3583');
        $this->addSql('ALTER TABLE demander_client DROP FOREIGN KEY FK_6CF32FFE4C21AB48');
        $this->addSql('ALTER TABLE demander_client DROP FOREIGN KEY FK_6CF32FFE19EB6921');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641019EB6921');
        $this->addSql('DROP TABLE demander');
        $this->addSql('DROP TABLE demander_operation');
        $this->addSql('DROP TABLE demander_client');
        $this->addSql('DROP TABLE facture');
    }
}
