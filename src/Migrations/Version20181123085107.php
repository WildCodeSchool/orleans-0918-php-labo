<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181123085107 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE company_customer (company_id INT NOT NULL, customer_id INT NOT NULL, INDEX IDX_99AE9B64979B1AD6 (company_id), INDEX IDX_99AE9B649395C3F3 (customer_id), PRIMARY KEY(company_id, customer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_customer ADD CONSTRAINT FK_99AE9B64979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_customer ADD CONSTRAINT FK_99AE9B649395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD company_id INT NOT NULL, ADD customer_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849559395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('CREATE INDEX IDX_42C84955979B1AD6 ON reservation (company_id)');
        $this->addSql('CREATE INDEX IDX_42C849559395C3F3 ON reservation (customer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE company_customer');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955979B1AD6');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849559395C3F3');
        $this->addSql('DROP INDEX IDX_42C84955979B1AD6 ON reservation');
        $this->addSql('DROP INDEX IDX_42C849559395C3F3 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP company_id, DROP customer_id');
    }
}
