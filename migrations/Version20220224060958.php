<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224060958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `authors`
        CHANGE COLUMN `last_name` `last_name` VARCHAR(45) NULL DEFAULT NULL COLLATE "utf8mb4_0900_ai_ci" AFTER `id`;');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `authors`
        CHANGE COLUMN `first_name` `first_name` VARCHAR(45) NULL DEFAULT NULL COLLATE "utf8mb4_0900_ai_ci" AFTER `id`;');
    }
}
