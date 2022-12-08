<?php

namespace Manikienko\Todo\Database;

abstract class Model extends Database
{

    public static function table(string $name): Database
    {
        throw new \LogicException('You cannot this ' . static::class . '::' . __METHOD__ . ' method in this context.');
    }

    public static function create(string $name, array $fields)
    {
        throw new \LogicException('You cannot this ' . static::class . '::' . __METHOD__ . ' method in this context.');
    }

    public static function remove($name)
    {
        throw new \LogicException('You cannot this ' . static::class . '::' . __METHOD__ . ' method in this context.');
    }

    public static function query(): static
    {
        return new static();
    }

    public function save($forceInsert = false)
    {
        parent::save($forceInsert);
        $this->find($this->lastId());
    }

    public function insert($forceInsert = false)
    {
        parent::insert($forceInsert);
        $this->find($this->lastId());
    }

    public function delete(int $id = null): bool
    {
        if ($id !== null) {
            $this->find($id)->delete();
        }

        return parent::delete();
    }

    public function exists(): bool
    {
        return $this->find()->count() > 0;
    }

    /**
     * @return static
     */
    public function first(): \Lazer\Classes\Database
    {
        return $this->limit(1)->find();
    }

    /**
     * @return static
     */
    public function last(): \Lazer\Classes\Database
    {
        return $this->orderBy('id', 'DESC')->first();
    }

}