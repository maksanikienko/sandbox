<?php

namespace Manikienko\Todo\Model;

use Manikienko\Todo\Database\Model;

class Exercise extends Model {

    public function defineSchema(): array
    {
        /*Создай миграцию по примеру той, что уже есть и в ней создай таблицу для упражнений (exercises)*/
        /* потом удали этот метод*/
        /* то же самое повтори с остальными моделями*/
        return [
            'name' => 'string',
            'difficulty_scale' => 'integer',
            'type' => 'string', //base,isolation
            'level' => 'string',
            'weight_type' => 'string',
        ];
    }
}