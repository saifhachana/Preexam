<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210603113259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, code_clt VARCHAR(10) NOT NULL, des__clt VARCHAR(255) NOT NULL, adr_clt VARCHAR(20) NOT NULL, tel_clt VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, code_clt_cde_id INT DEFAULT NULL, num_cde VARCHAR(10) NOT NULL, date_cde DATE NOT NULL, heure_cde VARCHAR(255) NOT NULL, remise_cde INT DEFAULT NULL, mnt_cde INT DEFAULT NULL, INDEX IDX_6EEAA67DC10EE90D (code_clt_cde_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, code_four VARCHAR(10) NOT NULL, des_four VARCHAR(255) NOT NULL, adr_four VARCHAR(100) NOT NULL, contact VARCHAR(100) DEFAULT NULL, contact_four VARCHAR(100) DEFAULT NULL, tel_four VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jouet (id INT AUTO_INCREMENT NOT NULL, code_four_jouet_id INT NOT NULL, code_jouet VARCHAR(10) NOT NULL, des_jouet VARCHAR(255) NOT NULL, qte_stock_jouet INT NOT NULL, pu_jouet INT NOT NULL, INDEX IDX_6B3DFFD85D20E737 (code_four_jouet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_cde (id INT AUTO_INCREMENT NOT NULL, num_cde_ligne_id INT DEFAULT NULL, code_jouet_ligne_id INT DEFAULT NULL, qte_ligne INT NOT NULL, remise_ligne INT DEFAULT NULL, INDEX IDX_5B71680BCFFB02A6 (num_cde_ligne_id), INDEX IDX_5B71680B1DA9D220 (code_jouet_ligne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DC10EE90D FOREIGN KEY (code_clt_cde_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE jouet ADD CONSTRAINT FK_6B3DFFD85D20E737 FOREIGN KEY (code_four_jouet_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE ligne_cde ADD CONSTRAINT FK_5B71680BCFFB02A6 FOREIGN KEY (num_cde_ligne_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_cde ADD CONSTRAINT FK_5B71680B1DA9D220 FOREIGN KEY (code_jouet_ligne_id) REFERENCES jouet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DC10EE90D');
        $this->addSql('ALTER TABLE ligne_cde DROP FOREIGN KEY FK_5B71680BCFFB02A6');
        $this->addSql('ALTER TABLE jouet DROP FOREIGN KEY FK_6B3DFFD85D20E737');
        $this->addSql('ALTER TABLE ligne_cde DROP FOREIGN KEY FK_5B71680B1DA9D220');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE jouet');
        $this->addSql('DROP TABLE ligne_cde');
    }
}
