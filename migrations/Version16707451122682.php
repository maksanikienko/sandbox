<?php

namespace Manikienko\Todo\Database;

use Manikienko\Todo\Model\Trainer;

class Version16707451122682 extends \Manikienko\Todo\Database\AbstractMigration
{
    public function up(Schema $schema): void
    {
        $schema->create(Trainer::getTableName(), [
            'full_name' => 'string',
            'age' => 'integer',
            'salary' => 'integer',
            'family_status' => 'string',
            'email' => 'string', 
        ]);


    }

    public function down(Schema $schema): void
    {
        $schema->drop(Trainer::getTableName());
    }
}