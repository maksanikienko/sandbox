<?php

namespace Manikienko\Todo\Database;

class ClientDatabase extends NamedDatabase
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