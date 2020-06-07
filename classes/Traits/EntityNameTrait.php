<?php

namespace Traits;

trait EntityNameTrait
{
    public static function getEntityName(): string
    {
        $class = explode('\\', static::class);
        return array_pop($class);
    }
}