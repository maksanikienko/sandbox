<?php

namespace Manikienko\Todo\Database;

abstract class Migration
{
    public function getVersion(): string
    {
        $class = new \ReflectionClass(static::class);
        return str_replace("Version", "", $class->getShortName());
    }
}