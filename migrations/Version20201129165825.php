<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201129165825 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE phone_book_entry (id INT AUTO_INCREMENT NOT NULL, fk_user INT DEFAULT NULL, name TINYTEXT NOT NULL, phone_number TINYTEXT NOT NULL, INDEX IDX_DE84E9C1AD0877 (fk_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shared_entries (id INT AUTO_INCREMENT NOT NULL, fk_phone_book_entry INT DEFAULT NULL, fk_user INT DEFAULT NULL, INDEX IDX_C2FBF725B8229EB (fk_phone_book_entry), INDEX IDX_C2FBF721AD0877 (fk_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phone_book_entry ADD CONSTRAINT FK_DE84E9C1AD0877 FOREIGN KEY (fk_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE shared_entries ADD CONSTRAINT FK_C2FBF725B8229EB FOREIGN KEY (fk_phone_book_entry) REFERENCES phone_book_entry (id)');
        $this->addSql('ALTER TABLE shared_entries ADD CONSTRAINT FK_C2FBF721AD0877 FOREIGN KEY (fk_user) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shared_entries DROP FOREIGN KEY FK_C2FBF725B8229EB');
        $this->addSql('ALTER TABLE phone_book_entry DROP FOREIGN KEY FK_DE84E9C1AD0877');
        $this->addSql('ALTER TABLE shared_entries DROP FOREIGN KEY FK_C2FBF721AD0877');
        $this->addSql('DROP TABLE phone_book_entry');
        $this->addSql('DROP TABLE shared_entries');
        $this->addSql('DROP TABLE user');
    }
}
