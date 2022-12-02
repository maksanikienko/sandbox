<?php

namespace Manikienko\Todo\Database;

use Manikienko\Todo\Model\Migration;

class Version16698804508404 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $schema->create(Migration::getTableName(), [
            'version' => 'string',
            'time' => 'integer',
            'batch' => 'integer',
        ]);
    }

    public function down(Schema $schema): void
    {
        $schema->drop(Migration::getTableName());
    }
}