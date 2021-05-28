<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210528142757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA75C69371E');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA77F5BCA73');
        $this->addSql('DROP INDEX IDX_3BAE0AA77F5BCA73 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA75C69371E ON event');
        $this->addSql('ALTER TABLE event DROP messagerie_expediteur_id, DROP messagerie_destinataire_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD messagerie_expediteur_id INT DEFAULT NULL, ADD messagerie_destinataire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA75C69371E FOREIGN KEY (messagerie_destinataire_id) REFERENCES messagerie (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA77F5BCA73 FOREIGN KEY (messagerie_expediteur_id) REFERENCES messagerie (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA77F5BCA73 ON event (messagerie_expediteur_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA75C69371E ON event (messagerie_destinataire_id)');
    }
}
