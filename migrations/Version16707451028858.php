<?php

namespace Manikienko\Todo\Database;

use Manikienko\Todo\Model\Gym;

class Version16707451028858 extends \Manikienko\Todo\Database\AbstractMigration
{
    public function up(Schema $schema): void
    {
        $schema->create(Gym::getTableName(), [
            'name' => 'string',
            'location' => 'string',
            'type' => 'string',
            'square' => 'integer',
            'segment_price' => 'string',  //cheap,expensive
        ]);


    }

    public function down(Schema $schema): void
    {
        $schema->drop(Gym::getTableName());

    }
}