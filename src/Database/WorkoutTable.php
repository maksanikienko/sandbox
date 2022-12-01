<?php

namespace Manikienko\Todo\Database;

class WorkoutTable extends AbstractTable {

    public function getTableName():  string
    {
        return 'workout';
    }

    public function defineSchema(): array
    {
        return [
            'type'=>'string',  //individual,group
            'duration'=>'integer',
            'rest_time'=>'integer',
            'place'=>'string' , //gym,stadium,home
            'method'=>'string', //interval,variable,circular
            'client_id' => 'string'

        ];
    }
}