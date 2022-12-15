<?php

namespace Manikienko\Todo\Database;

use Lazer\Classes\Database as BaseDatabase;
use Lazer\Classes\Helpers\Config;
use Lazer\Classes\Helpers\Data;
use Symfony\Component\String\ByteString;
use Symfony\Component\String\Inflector\EnglishInflector;

abstract class Database extends BaseDatabase
{
    private static array $tableNameCache = [];

    final public function __construct()
    {
        $this->name = $this::getTableName();
        $this->setFields();
        $this->setPending();
    }

    public static function getTableName(): string
    {
        if (isset(self::$tableNameCache[static::class])) {
            return self::$tableNameCache[static::class];
        }

        $inflector = new EnglishInflector();
        $className = (new ByteString(static::class))
            ->afterLast("\\")
            ->lower();

        [$tableName] = $inflector->pluralize($className);

        self::$tableNameCache[static::class] = $tableName;

        return $tableName;
    }

    public static function tableExists(): bool
    {
        try {
            return Config::table(self::getTableName())->exists() && Data::table(self::getTableName())->exists();
        } catch (\Throwable) {
            return false;
        }
    }

    public static function table(string $name): Database
    {
        throw new \LogicException('You cannot this ' . static::class . '::' . __METHOD__ . ' method in this context.');
    }

    public function findAll(bool $asArray = false): BaseDatabase|array
    {
        if ($asArray) {
            return array_map(fn($row) => (array)$row, iterator_to_array(parent::findAll()));
        }

        return parent::findAll();
    }

    public function asArray(string $key = null, string $value = null, string $v2 = null)
    {
        if (empty($this->data) && !empty($this->set)) {
            return (array) $this->set;
        }

        return parent::asArray($key, $value, $v2);
    }

}