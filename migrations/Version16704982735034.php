<?php

namespace Manikienko\Todo\Database;

use Manikienko\Todo\Model\Client;

class Version16704982735034 extends \Manikienko\Todo\Database\AbstractMigration
{
    public function up(Schema $schema): void
    {
        $schema->forTable(Client::getTableName(), function (Schema $table){
            $table->addField('email', 'string');
        });

    }

    public function down(Schema $schema): void
    {
        $schema->forTable(Client::getTableName(), function (Schema $table){
            $table->removeField('email');
        });
    }
}