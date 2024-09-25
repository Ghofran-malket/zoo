<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240925212455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zoo ADD opening_time VARCHAR(100) NOT NULL, DROP open_hour, DROP close_hour');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zoo ADD open_hour TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', ADD close_hour TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', DROP opening_time');
    }
}
