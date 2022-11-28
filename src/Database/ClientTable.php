<?php

namespace Manikienko\Todo\Database;

class ClientTable extends AbstractTable
{
    public function getTableName():  string
    {
        return 'clients';
    }

    public function defineSchema(): array
    {
        return [
            'name' => 'string',
            'age' => 'integer',
            'status' => 'string',
        ];
    }
}