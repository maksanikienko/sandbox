<?php

namespace Manikienko\Todo\Database;

class ExerciseDatabase extends NamedDatabase {

    public function getTableName():  string
    {
        return 'exercises';
    }

    public function defineSchema(): array
    {
        return [
            'name' => 'string',
            'difficulty_scale' => 'integer',
            'type' => 'string', //base,isolation
            'level' => 'string',
            'weight_type' => 'string',
        ];
    }
}