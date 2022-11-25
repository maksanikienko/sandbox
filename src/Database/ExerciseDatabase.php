<?php

namespace Manikienko\Todo\Database;

class ExerciseDatabase extends NamedDatabase{
    
    public function getTableName():  string
    {
        return 'Exercises';
    }

    protected function createSchema(): void
    {
        self::create('Exercises', [
            'name' => 'string',
            'difficultyScale' => 'integer',
            'type' => 'string', //base,isolation
            'level'=> 'string', 
            'weightType' => 'string',
        ]);

    }
}