<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223193148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'added book_author foreign key';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `books`
        ADD CONSTRAINT `book_author` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT;');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `books`
        DROP FOREIGN KEY `book_author`;');
    }
}
