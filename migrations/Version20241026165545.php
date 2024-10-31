<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241026165545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cabinet ADD patients_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cabinet ADD CONSTRAINT FK_4CED05B0CEC3FD2F FOREIGN KEY (patients_id) REFERENCES patient (id)');
        $this->addSql('CREATE INDEX IDX_4CED05B0CEC3FD2F ON cabinet (patients_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cabinet DROP FOREIGN KEY FK_4CED05B0CEC3FD2F');
        $this->addSql('DROP INDEX IDX_4CED05B0CEC3FD2F ON cabinet');
        $this->addSql('ALTER TABLE cabinet DROP patients_id');
    }
}
