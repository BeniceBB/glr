<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517090159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendee ADD student_id INT DEFAULT NULL, ADD trip_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attendee ADD CONSTRAINT FK_1150D567CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE attendee ADD CONSTRAINT FK_1150D567A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('CREATE INDEX IDX_1150D567CB944F1A ON attendee (student_id)');
        $this->addSql('CREATE INDEX IDX_1150D567A5BC2E0E ON attendee (trip_id)');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33BCFD782A');
        $this->addSql('DROP INDEX IDX_B723AF33BCFD782A ON student');
        $this->addSql('ALTER TABLE student DROP attendee_id');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BBCFD782A');
        $this->addSql('DROP INDEX IDX_7656F53BBCFD782A ON trip');
        $this->addSql('ALTER TABLE trip DROP attendee_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendee DROP FOREIGN KEY FK_1150D567CB944F1A');
        $this->addSql('ALTER TABLE attendee DROP FOREIGN KEY FK_1150D567A5BC2E0E');
        $this->addSql('DROP INDEX IDX_1150D567CB944F1A ON attendee');
        $this->addSql('DROP INDEX IDX_1150D567A5BC2E0E ON attendee');
        $this->addSql('ALTER TABLE attendee DROP student_id, DROP trip_id');
        $this->addSql('ALTER TABLE student ADD attendee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33BCFD782A FOREIGN KEY (attendee_id) REFERENCES attendee (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B723AF33BCFD782A ON student (attendee_id)');
        $this->addSql('ALTER TABLE trip ADD attendee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BBCFD782A FOREIGN KEY (attendee_id) REFERENCES attendee (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7656F53BBCFD782A ON trip (attendee_id)');
    }
}
