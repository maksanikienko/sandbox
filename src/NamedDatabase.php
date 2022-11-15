<?php

namespace Manikienko\Todo;

use Lazer\Classes\Database;
use Lazer\Classes\Helpers\Config;
use Lazer\Classes\Helpers\Data;
use Lazer\Classes\Helpers\Validate;

/*
 * объект абстрактного класса нельзя создать, но в этом классе можно обьявить абстрактные методы которые
 * ты должен имплементировать в дочерних классах
 */

abstract class NamedDatabase extends Database
{
    /*final запрещает переписывание метода в дочернем классе, тут это сделало чтобы никто не мог просто так поменять
     *  поведение конструктора в дочерних классах.
     */
    final public function __construct()
    {
        // эта часть была добавлена
        if (!$this->databaseExists()) {
            $this->createSchema();
        }

        // эта часть была взята из Database::table(...)
        $this->name = $this->getTableName();
        $this->setFields();
        $this->setPending();
    }

    abstract public function getTableName(): string;

    abstract protected function createSchema(): void;


    public function databaseExists(): bool
    {
        return Config::table($this->getTableName())->exists() && Data::table($this->getTableName())->exists();
    }

    public static function table(string $name): Database
    {
        throw new \LogicException('You cannot initialize another database through a named database.');
    }

    public function findAll(bool $asArray = false)
    {
        $data = parent::findAll();
        if ($asArray) {
            $result = [];
            foreach ($data as $index => $row) {
                $result[$index] = (array)$row;
            }
            $data = $result;
        }

        return $data;
    }

}