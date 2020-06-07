<?php


use Interfaces\StorageInterface;

class FileStorage implements StorageInterface
{
    static $instance = false;

    protected $file;

    private function __construct()
    {
        $this->file = realpath($_ENV['FILE_STORAGE_DIR']) . '/family';
    }

    public static function getInstance(): StorageInterface
    {
        if (!self::$instance) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    public function storeFamily(array $familyMembers): bool
    {
        return file_put_contents($this->file, serialize($familyMembers)) !== false;
    }

    public function loadFamily(): array
    {
        try {
            $family = unserialize(file_get_contents($this->file)) ?: [];
        } catch (Exception $e) {
            $family = [];
        }

        return $family;
    }


}