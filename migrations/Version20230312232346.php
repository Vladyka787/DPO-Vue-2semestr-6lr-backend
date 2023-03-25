<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230312232346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE education_information_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE resume_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE education_information (id INT NOT NULL, resume_id INT NOT NULL, educational_institution VARCHAR(255) NOT NULL, faculty VARCHAR(255) NOT NULL, specialization VARCHAR(255) NOT NULL, year_of_ending INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6CFBB801D262AF09 ON education_information (resume_id)');
        $this->addSql('CREATE TABLE resume (id INT NOT NULL, status VARCHAR(30) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, patronymic VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, profession VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, birthdate VARCHAR(255) NOT NULL, level_of_education VARCHAR(255) NOT NULL, salary VARCHAR(255) NOT NULL, key_skills VARCHAR(255) NOT NULL, about_me VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE education_information ADD CONSTRAINT FK_6CFBB801D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE education_information_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE resume_id_seq CASCADE');
        $this->addSql('ALTER TABLE education_information DROP CONSTRAINT FK_6CFBB801D262AF09');
        $this->addSql('DROP TABLE education_information');
        $this->addSql('DROP TABLE resume');
    }
}
