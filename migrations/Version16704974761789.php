<?php

namespace Manikienko\Todo\Database;

use Manikienko\Todo\Model\Client;

class Version16704974761789 extends \Manikienko\Todo\Database\AbstractMigration
{
    public function up(Schema $schema): void
    {
        $schema->create(Client::getTableName(), [
            'name' => 'string',
            'age' => 'integer',
            'status' => 'string',
        ]);

    }

    public function down(Schema $schema): void
    {
        $schema->drop(Client::getTableName());
    }
}