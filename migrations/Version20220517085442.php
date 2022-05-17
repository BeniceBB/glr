<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517085442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attendee (id INT AUTO_INCREMENT NOT NULL, identity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE attendees');
        $this->addSql('ALTER TABLE student ADD attendee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33BCFD782A FOREIGN KEY (attendee_id) REFERENCES attendee (id)');
        $this->addSql('CREATE INDEX IDX_B723AF33BCFD782A ON student (attendee_id)');
        $this->addSql('ALTER TABLE trip ADD attendee_id INT DEFAULT NULL, ADD destination VARCHAR(100) NOT NULL, DROP location, CHANGE title title VARCHAR(100) NOT NULL, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BBCFD782A FOREIGN KEY (attendee_id) REFERENCES attendee (id)');
        $this->addSql('CREATE INDEX IDX_7656F53BBCFD782A ON trip (attendee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33BCFD782A');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BBCFD782A');
        $this->addSql('CREATE TABLE attendees (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, trip_id INT NOT NULL, identity INT NOT NULL, INDEX IDX_C8C96B25A5BC2E0E (trip_id), INDEX IDX_C8C96B25CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE attendees ADD CONSTRAINT FK_C8C96B25A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE attendees ADD CONSTRAINT FK_C8C96B25CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE attendee');
        $this->addSql('DROP INDEX IDX_B723AF33BCFD782A ON student');
        $this->addSql('ALTER TABLE student DROP attendee_id');
        $this->addSql('DROP INDEX IDX_7656F53BBCFD782A ON trip');
        $this->addSql('ALTER TABLE trip ADD location VARCHAR(50) NOT NULL, DROP attendee_id, DROP destination, CHANGE title title VARCHAR(50) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
    }
}
