<?php

namespace Manikienko\Todo\Model;

use Manikienko\Todo\Database\Model;

class Workout extends Model
{

    public function defineSchema(): array
    {
        return [
            'type' => 'string',  //individual,group
            'duration' => 'integer',
            'rest_time' => 'integer',
            'place' => 'string', //gym,stadium,home
            'method' => 'string', //interval,variable,circular
            'client_id' => 'string'

        ];
    }
}