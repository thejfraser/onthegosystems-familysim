<?php

namespace Factories;

use FileStorage;
use Interfaces\StorageInterface;

class Storage
{
    public static function get(): StorageInterface
    {
        //here we can switch between storage methods, im using file for now, but we'd have something to flip it
        return FileStorage::getInstance();
    }
}