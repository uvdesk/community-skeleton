<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190701051311 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE uv_user CHANGE is_enabled is_enabled TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE uv_ticket CHANGE subject subject LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE uv_saved_replies CHANGE is_predefind is_predefind TINYINT(1) DEFAULT \'1\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE uv_saved_replies CHANGE is_predefind is_predefind TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE uv_ticket CHANGE subject subject LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE uv_user CHANGE is_enabled is_enabled TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
}
