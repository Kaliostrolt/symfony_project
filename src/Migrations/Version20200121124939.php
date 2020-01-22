<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200121124939 extends AbstractMigration
{
    private $roles = [
        "admin" => "Admin",
        "manager" => "Manager",
        "user" => "User"
    ];

    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        foreach ($this->roles as $key => $value) {
                $id = Uuid::uuid4();
                $this->addSql("INSERT INTO role (id, name, label, creaded_at, creaded_by) VALUES ('$id','$key', '$value', now(), '66aca6ab-8b58-4d14-8294-af9857877d4a')");
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $keyRoles = implode("', '", array_keys($this->roles));
        $this->addSql("DELETE FROM role WHERE name IN('$keyRoles')");
    }
}
