<?php

namespace Manikienko\Todo\Database;

use Lazer\Classes\Database;
use Lazer\Classes\Relation;

final class Schema
{
    protected ?Database $database;

    public function drop(string $table): Schema
    {
        Database::remove($table);

        return $this;
    }

    public function create(string $table, array $schema): self
    {
        Database::create($table, $schema);

        return $this;
    }

    public function forTable(string $table, callable $callback): self
    {
        $this->database = Database::table($table);
        $callback($this);
        $this->database = null;

        return $this;
    }

    public function addField(string $field, string $type): self
    {
        $this->database->addFields([$field => $type]);

        return $this;
    }

    public function removeField(string $field): self
    {
        $this->database->deleteFields([$field]);

        return $this;
    }

    public function createRelation(): Relation
    {
        return Relation::table($this->database->name());
    }

    public function removeRelation(string $withTable): Schema
    {
        Relation::table($this->database->name())
            ->with($withTable)
            ->removeRelation();

        return $this;
    }
}