<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241003114304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report_de_sante ADD veterinaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE report_de_sante ADD CONSTRAINT FK_1C9FF4435C80924 FOREIGN KEY (veterinaire_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1C9FF4435C80924 ON report_de_sante (veterinaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report_de_sante DROP FOREIGN KEY FK_1C9FF4435C80924');
        $this->addSql('DROP INDEX IDX_1C9FF4435C80924 ON report_de_sante');
        $this->addSql('ALTER TABLE report_de_sante DROP veterinaire_id');
    }
}
