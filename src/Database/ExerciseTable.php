<?php

namespace Manikienko\Todo\Database;

class ExerciseTable extends AbstractTable {

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