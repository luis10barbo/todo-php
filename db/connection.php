<?php
class Database
{
    private static PDO $db;
    // private static TodoTable $todo_table;
    private function __construct()
    {
    }

    public static function get()
    {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO("sqlite:" . __DIR__ . DIRECTORY_SEPARATOR . "database.db");
            } catch (PDOException $e) {
                $error = $e->getCode();
                var_dump($error);
                exit();
            }
        }

        return self::$db;
    }

    // public static function todo()
    // {
    //     if (!isset(self::$todo_table)) {
    //         self::$todo_table = new TodoTable(self::get());
    //     }

    //     return self::$todo_table;
    // }
}
