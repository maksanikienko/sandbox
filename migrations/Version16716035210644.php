<?php

namespace Manikienko\Todo\Database;

use Manikienko\Todo\Model\Client;
use Manikienko\Todo\Model\Trainer;
use Manikienko\Todo\Model\Workout;

class Version16716035210644 extends \Manikienko\Todo\Database\AbstractMigration
{
    public function up(Schema $schema): void
    {
        $schema->forTable(Workout::getTableName(), function (Schema $schema) {

            $schema->addField('client_id', 'integer');

            /* тренировка принадлежит клиентам */
            $schema
                ->createRelation()
                ->belongsTo(Client::getTableName())
                ->localKey('client_id' /*ключ из таблицы workout в котором хранится Client::$id */)
                ->foreignKey('id' /* поле в таблице clients которое является идентивфикатором клиента */)
                ->setRelation();
        });

        $schema->forTable(Client::getTableName(), function (Schema $schema) {
            /* клиенту принадлежат тренировки */
            $schema
                ->createRelation()
                ->hasMany(Workout::getTableName())/* hasMany это другая стороная belongsTo. */
                ->localKey('id')
                ->foreignKey('client_id')
                ->setRelation();
        });
    }

    public function down(Schema $schema): void
    {
        $schema->forTable(Workout::getTableName(), function (Schema $schema) {
            $schema->removeField('client_id');

            $schema->removeRelation(Client::getTableName());
        });

        $schema->forTable(Client::getTableName(), function (Schema $schema) {
            $schema->removeRelation(Workout::getTableName());
        });
    }
}