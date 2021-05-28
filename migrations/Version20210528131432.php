<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210528131432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messagerie_user');
        $this->addSql('ALTER TABLE messagerie DROP FOREIGN KEY FK_14E8F60CA4F84F6E');
        $this->addSql('DROP INDEX IDX_14E8F60CA4F84F6E ON messagerie');
        $this->addSql('ALTER TABLE messagerie DROP destinataire_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messagerie_user (messagerie_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3F145465A76ED395 (user_id), INDEX IDX_3F145465836C1031 (messagerie_id), PRIMARY KEY(messagerie_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE messagerie_user ADD CONSTRAINT FK_3F145465836C1031 FOREIGN KEY (messagerie_id) REFERENCES messagerie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE messagerie_user ADD CONSTRAINT FK_3F145465A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE messagerie ADD destinataire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messagerie ADD CONSTRAINT FK_14E8F60CA4F84F6E FOREIGN KEY (destinataire_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_14E8F60CA4F84F6E ON messagerie (destinataire_id)');
    }
}
