<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240925205130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F57348798');
        $this->addSql('DROP INDEX IDX_6AAB231F57348798 ON animal');
        $this->addSql('ALTER TABLE animal CHANGE habitats_id_id habitats_id INT NOT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F35D3C6F5 FOREIGN KEY (habitats_id) REFERENCES habitats (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F35D3C6F5 ON animal (habitats_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F35D3C6F5');
        $this->addSql('DROP INDEX IDX_6AAB231F35D3C6F5 ON animal');
        $this->addSql('ALTER TABLE animal CHANGE habitats_id habitats_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F57348798 FOREIGN KEY (habitats_id_id) REFERENCES habitats (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F57348798 ON animal (habitats_id_id)');
    }
}
