<?php

namespace Manikienko\Todo\Database;

use Manikienko\Todo\Model\Workout;

class Version16706678242929 extends \Manikienko\Todo\Database\AbstractMigration
{
    public function up(Schema $schema): void
    {
        $schema->create(Workout::getTableName(), [
            'type' => 'string',
            'duration' => 'integer',
            'rest_time' => 'integer',
            'place' => 'string',
            'method' => 'string', 
            'client_id' => 'integer' 
        ]);


    }

    public function down(Schema $schema): void
    {
        $schema->drop(Workout::getTableName());

    }
}