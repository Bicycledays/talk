<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417161637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `member` (id INT AUTO_INCREMENT NOT NULL, talker_id INT DEFAULT NULL, talk_id INT DEFAULT NULL, viewed_message_id INT DEFAULT NULL, INDEX IDX_70E4FA7870C67352 (talker_id), INDEX IDX_70E4FA786F0601D5 (talk_id), INDEX IDX_70E4FA78737085F5 (viewed_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `member` ADD CONSTRAINT FK_70E4FA7870C67352 FOREIGN KEY (talker_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `member` ADD CONSTRAINT FK_70E4FA786F0601D5 FOREIGN KEY (talk_id) REFERENCES talk (id)');
        $this->addSql('ALTER TABLE `member` ADD CONSTRAINT FK_70E4FA78737085F5 FOREIGN KEY (viewed_message_id) REFERENCES message (id)');
        $this->addSql('DROP TABLE talk_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE talk_user (talk_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6FB6AE156F0601D5 (talk_id), INDEX IDX_6FB6AE15A76ED395 (user_id), PRIMARY KEY(talk_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE talk_user ADD CONSTRAINT FK_6FB6AE156F0601D5 FOREIGN KEY (talk_id) REFERENCES talk (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE talk_user ADD CONSTRAINT FK_6FB6AE15A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE `member`');
    }
}
