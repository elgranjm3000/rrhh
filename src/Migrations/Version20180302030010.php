<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180302030010 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE asignar ADD CONSTRAINT FK_8F6C911AFD61E233 FOREIGN KEY (idusuario) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE asignar ADD CONSTRAINT FK_8F6C911AD66B3D98 FOREIGN KEY (idmaterial) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_8F6C911AFD61E233 ON asignar (idusuario)');
        $this->addSql('CREATE INDEX IDX_8F6C911AD66B3D98 ON asignar (idmaterial)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE asignar DROP FOREIGN KEY FK_8F6C911AFD61E233');
        $this->addSql('ALTER TABLE asignar DROP FOREIGN KEY FK_8F6C911AD66B3D98');
        $this->addSql('DROP INDEX IDX_8F6C911AFD61E233 ON asignar');
        $this->addSql('DROP INDEX IDX_8F6C911AD66B3D98 ON asignar');
    }
}
