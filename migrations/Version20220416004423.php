<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416004423 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE airline (id INT AUTO_INCREMENT NOT NULL, nomairline VARCHAR(30) NOT NULL, pays VARCHAR(30) NOT NULL, stars INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vol (id INT AUTO_INCREMENT NOT NULL, airline_id INT DEFAULT NULL, datedepart DATE NOT NULL, datearrive DATE NOT NULL, nom VARCHAR(30) NOT NULL, heuredepart TIME NOT NULL, heurearrive TIME NOT NULL, destination VARCHAR(30) NOT NULL, nbrplace INT NOT NULL, nomairline VARCHAR(30) NOT NULL, INDEX IDX_95C97EB130D0C16 (airline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EB130D0C16 FOREIGN KEY (airline_id) REFERENCES airline (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB130D0C16');
        $this->addSql('DROP TABLE airline');
        $this->addSql('DROP TABLE vol');
    }
}
