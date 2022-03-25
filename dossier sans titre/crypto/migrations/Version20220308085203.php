<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308085203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_crypto (user_id INT NOT NULL, crypto_id INT NOT NULL, INDEX IDX_D7A33B8A76ED395 (user_id), INDEX IDX_D7A33B8E9571A63 (crypto_id), PRIMARY KEY(user_id, crypto_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_crypto ADD CONSTRAINT FK_D7A33B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_crypto ADD CONSTRAINT FK_D7A33B8E9571A63 FOREIGN KEY (crypto_id) REFERENCES crypto (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_crypto');
    }
}
