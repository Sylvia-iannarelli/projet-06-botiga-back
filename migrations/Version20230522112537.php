<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522112537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orderline (id INT AUTO_INCREMENT NOT NULL, order_code_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_DF24E26CD1A0575C (order_code_id), INDEX IDX_DF24E26C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orderline ADD CONSTRAINT FK_DF24E26CD1A0575C FOREIGN KEY (order_code_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE orderline ADD CONSTRAINT FK_DF24E26C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderline DROP FOREIGN KEY FK_DF24E26CD1A0575C');
        $this->addSql('ALTER TABLE orderline DROP FOREIGN KEY FK_DF24E26C4584665A');
        $this->addSql('DROP TABLE orderline');
    }
}
