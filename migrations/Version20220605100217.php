<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220605100217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE books RENAME COLUMN name TO title');
        $this->addSql('ALTER TABLE books DROP FOREIGN KEY `book_author`');
        $this->addSql('ALTER TABLE books DROP COLUMN author_id');
        $this->addSql('ALTER TABLE book_authors RENAME TO book_author');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE books RENAME COLUMN title TO name;');
        $this->addSql('ALTER TABLE books ADD COLUMN author_id INT UNSIGNED NOT NULL AFTER name;');
        $this->addSql('ALTER TABLE `books`
        ADD CONSTRAINT `book_author` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT;');
        $this->addSql('ALTER TABLE book_author RENAME TO book_authors;');
    }
}
