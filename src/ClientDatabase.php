<?php

namespace Manikienko\Todo;

class ClientDatabase extends NamedDatabase
{
    public function getTableName(): string
    {
        return 'clients';
    }

    protected function createSchema(): void
    {
        self::create('clients', [
            'name' => 'string',
            'age' => 'integer',
            'status' => 'string',
        ]);

    }

}