<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416131957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invite ADD sender_id INT DEFAULT NULL, ADD new_user_id INT DEFAULT NULL, ADD hash VARCHAR(32) NOT NULL, DROP url');
        $this->addSql('ALTER TABLE invite ADD CONSTRAINT FK_C7E210D7F624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE invite ADD CONSTRAINT FK_C7E210D77C2D807B FOREIGN KEY (new_user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_C7E210D7F624B39D ON invite (sender_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7E210D77C2D807B ON invite (new_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invite DROP FOREIGN KEY FK_C7E210D7F624B39D');
        $this->addSql('ALTER TABLE invite DROP FOREIGN KEY FK_C7E210D77C2D807B');
        $this->addSql('DROP INDEX IDX_C7E210D7F624B39D ON invite');
        $this->addSql('DROP INDEX UNIQ_C7E210D77C2D807B ON invite');
        $this->addSql('ALTER TABLE invite ADD url VARCHAR(255) NOT NULL, DROP sender_id, DROP new_user_id, DROP hash');
    }
}
