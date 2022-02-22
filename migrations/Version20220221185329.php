<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221185329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adding shelves, books, user_book_rating, book_authors, authors tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `users`
        CHANGE COLUMN `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST;');

        $this->addSql("CREATE TABLE IF NOT EXISTS `booki`.`authors` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `first_name` VARCHAR(45) NULL,
            `last_name` VARCHAR(45) NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `uq_author_name` (`first_name` ASC, `last_name` ASC) VISIBLE)
          ENGINE = InnoDB");

        $this->addSql("CREATE TABLE IF NOT EXISTS `booki`.`books` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `author_id` INT UNSIGNED NOT NULL,
            `publisher` VARCHAR(50) NULL,
            `publish_year` VARCHAR(50) NULL,
            `publish_place` VARCHAR(50) NULL,
            `edition` VARCHAR(50) NULL,
            `pages` SMALLINT(5) NULL,
            `translator_id` INT NULL,
            `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
            ENGINE = InnoDB"
        );

        $this->addSql("CREATE TABLE IF NOT EXISTS `booki`.`shelves` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `user_id` INT UNSIGNED NOT NULL,
            `book_id` INT NOT NULL,
            `status` ENUM('to read', 'currently_reading', 'read') NULL DEFAULT 'to read',
            `name` VARCHAR(45) NULL,
            `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `user_list` (`user_id` ASC, `name` ASC) VISIBLE,
            CONSTRAINT `user`
              FOREIGN KEY (`user_id`)
              REFERENCES `booki`.`users` (`id`)
              ON DELETE CASCADE
              ON UPDATE CASCADE,
            CONSTRAINT `book`
              FOREIGN KEY (`id`)
              REFERENCES `booki`.`books` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION)
          ENGINE = InnoDB");       

        $this->addSql(
        "CREATE TABLE IF NOT EXISTS `booki`.`user_book_rating` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `user_id` INT UNSIGNED NOT NULL,
            `book_id` INT UNSIGNED NOT NULL,
            `rating` BINARY(10) NULL,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `user_books` (`user_id` ASC, `book_id` ASC) VISIBLE,
            INDEX `book_id_idx` (`book_id` ASC) VISIBLE,
            CONSTRAINT `user`
              FOREIGN KEY (`user_id`)
              REFERENCES `booki`.`users` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            CONSTRAINT `book`
              FOREIGN KEY (`book_id`)
              REFERENCES `booki`.`books` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION)
          ENGINE = InnoDB"
        );
        
        $this->addSql("CREATE TABLE IF NOT EXISTS `booki`.`book_authors` (
            `book_id` INT UNSIGNED NOT NULL,
            `author_id` INT UNSIGNED NOT NULL,
            INDEX `book_idx` (`book_id` ASC) VISIBLE,
            INDEX `author_idx` (`author_id` ASC) VISIBLE,
            CONSTRAINT `user_book`
              FOREIGN KEY (`book_id`)
              REFERENCES `booki`.`books` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            CONSTRAINT `author`
              FOREIGN KEY (`author_id`)
              REFERENCES `booki`.`authors` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION)
          ENGINE = InnoDB");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP table shelves');
        $this->addSql('DROP table books');
        $this->addSql('DROP table user_book_rating');
        $this->addSql('DROP table book_authors');
        $this->addSql('DROP table authors');
        $this->addSql('ALTER TABLE `users`
        CHANGE COLUMN `id` `id` INT(10) NOT NULL AUTO_INCREMENT FIRST;');
    }
}
