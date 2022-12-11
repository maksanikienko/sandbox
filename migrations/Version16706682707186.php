<?php

namespace Manikienko\Todo\Database;

use Manikienko\Todo\Model\Exercise;

class Version16706682707186 extends \Manikienko\Todo\Database\AbstractMigration
{
    public function up(Schema $schema): void
    {
        $schema->create(Exercise::getTableName(), [
            'name' => 'string',
            'difficulty_scale' => 'integer',
            'type' => 'string',
            'level' => 'string',
            'weight_type' => 'string',
        ]);

    }

    public function down(Schema $schema): void
    {
        $schema->drop(Exercise::getTableName());
        
    }
}