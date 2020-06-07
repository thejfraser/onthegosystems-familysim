<?php

namespace Interfaces;

Interface StorageInterface
{
    public static function getInstance(): StorageInterface;

    public function storeFamily(array $familyMembers): bool;

    public function loadFamily(): array;
}