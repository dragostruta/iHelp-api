<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200721130230 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parking_spot (id INT AUTO_INCREMENT NOT NULL, parking_place_id INT NOT NULL, vehicle_id INT NOT NULL, expire_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_C1A60A006B2E732B (parking_place_id), UNIQUE INDEX UNIQ_C1A60A00545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicles (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, license_plate VARCHAR(255) NOT NULL, INDEX IDX_1FCE69FAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parking_place (id INT AUTO_INCREMENT NOT NULL, zone_id INT NOT NULL, address VARCHAR(255) NOT NULL, number_parking_spots_total INT DEFAULT NULL, number_parking_spots_free INT DEFAULT NULL, price_per_hour INT DEFAULT NULL, currency VARCHAR(255) NOT NULL, INDEX IDX_BD69E73B9F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_A0EBC0078BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parking_spot ADD CONSTRAINT FK_C1A60A006B2E732B FOREIGN KEY (parking_place_id) REFERENCES parking_place (id)');
        $this->addSql('ALTER TABLE parking_spot ADD CONSTRAINT FK_C1A60A00545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicles (id)');
        $this->addSql('ALTER TABLE vehicles ADD CONSTRAINT FK_1FCE69FAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE parking_place ADD CONSTRAINT FK_BD69E73B9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE zone ADD CONSTRAINT FK_A0EBC0078BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE zone DROP FOREIGN KEY FK_A0EBC0078BAC62AF');
        $this->addSql('ALTER TABLE parking_spot DROP FOREIGN KEY FK_C1A60A00545317D1');
        $this->addSql('ALTER TABLE parking_spot DROP FOREIGN KEY FK_C1A60A006B2E732B');
        $this->addSql('ALTER TABLE parking_place DROP FOREIGN KEY FK_BD69E73B9F2C3FAB');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE parking_spot');
        $this->addSql('DROP TABLE vehicles');
        $this->addSql('DROP TABLE parking_place');
        $this->addSql('DROP TABLE zone');
    }
}
