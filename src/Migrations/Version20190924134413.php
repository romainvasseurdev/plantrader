<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190924134413 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category_echange (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE echange ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE echange ADD CONSTRAINT FK_B577E3BF12469DE2 FOREIGN KEY (category_id) REFERENCES category_echange (id)');
        $this->addSql('CREATE INDEX IDX_B577E3BF12469DE2 ON echange (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE echange DROP FOREIGN KEY FK_B577E3BF12469DE2');
        $this->addSql('DROP TABLE category_echange');
        $this->addSql('DROP INDEX IDX_B577E3BF12469DE2 ON echange');
        $this->addSql('ALTER TABLE echange DROP category_id');
    }
}
