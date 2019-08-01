<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190723070547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_skus (id INT AUTO_INCREMENT NOT NULL, products_id INT NOT NULL, name VARCHAR(120) DEFAULT NULL, image VARCHAR(120) DEFAULT NULL, sku VARCHAR(120) DEFAULT NULL, status SMALLINT NOT NULL, date_added DATE DEFAULT NULL, date_available DATE DEFAULT NULL, sort SMALLINT DEFAULT 1 NOT NULL, INDEX IDX_AE07B3B6C8A81A9 (products_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, link VARCHAR(120) DEFAULT NULL, name VARCHAR(120) DEFAULT NULL, description LONGTEXT DEFAULT NULL, images JSON DEFAULT NULL COMMENT \'(DC2Type:json_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_skus ADD CONSTRAINT FK_AE07B3B6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_skus DROP FOREIGN KEY FK_AE07B3B6C8A81A9');
        $this->addSql('DROP TABLE product_skus');
        $this->addSql('DROP TABLE products');
    }
}
