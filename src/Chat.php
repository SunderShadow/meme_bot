<?php

namespace Core;

use PDO;

class Chat
{
    public int $id;

    private readonly PDO $connection;

    public function __construct()
    {
        $this->connection = DB::getInstance();
    }

    public function save(): void
    {
        $query = $this->connection->prepare("INSERT INTO chats(id) VALUES (?)");

        try {
            $query->execute([$this->id]);
        } catch (\Exception $e) {
            if ($e->getCode() != 23000) {
                throw $e;
            }
        }
    }

    /**
     * @return static[]
     */
    public static function all(): array
    {
        return
            DB::getInstance()
                ->query('SELECT * FROM chats')
                ->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function create(int $id): void
    {
        $user = new static();
        $user->id = $id;

        $user->save();
    }
}