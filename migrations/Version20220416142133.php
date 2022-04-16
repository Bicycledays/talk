<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416142133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE talk ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE talk ADD CONSTRAINT FK_9F24D5BB7E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_9F24D5BB7E3C61F9 ON talk (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE talk DROP FOREIGN KEY FK_9F24D5BB7E3C61F9');
        $this->addSql('DROP INDEX IDX_9F24D5BB7E3C61F9 ON talk');
        $this->addSql('ALTER TABLE talk DROP owner_id');
    }
}
