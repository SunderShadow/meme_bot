<?php

namespace Core;

use PDO;

class DB extends PDO
{
    protected static self $instance;

    const string DB_FILEPATH = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db.sq3';

    public function __construct()
    {
        parent::__construct('sqlite:' . self::DB_FILEPATH);
    }

    public static function getInstance(): static
    {
        if (!isset(static::$instance)) {
            static::$instance = new self();
        }

        return static::$instance;
    }
}