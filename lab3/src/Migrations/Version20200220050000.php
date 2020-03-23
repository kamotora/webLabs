<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200220050000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autoservice (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(1024) NOT NULL, date_add DATE NOT NULL, description VARCHAR(2048) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, name VARCHAR(1024) NOT NULL, photo VARCHAR(1024) NOT NULL, tel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autoservice_service (autoservice_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_1229EE0C8D04C1EA (autoservice_id), INDEX IDX_1229EE0CED5CA9E6 (service_id), PRIMARY KEY(autoservice_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE autoservice_service ADD CONSTRAINT FK_1229EE0C8D04C1EA FOREIGN KEY (autoservice_id) REFERENCES autoservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE autoservice_service ADD CONSTRAINT FK_1229EE0CED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE autoservice_service DROP FOREIGN KEY FK_1229EE0CED5CA9E6');
        $this->addSql('ALTER TABLE autoservice_service DROP FOREIGN KEY FK_1229EE0C8D04C1EA');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE autoservice');
        $this->addSql('DROP TABLE autoservice_service');
    }
}
