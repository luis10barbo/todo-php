<?php
require_once(__DIR__ . "/tables/session_table.php");
require_once(__DIR__ . "/tables/user_table.php");
require_once(__DIR__ . "/tables/todo_table.php");
class Database
{
    private static PDO $db;

    private static TodoTable $todo_table;
    private static SessionTable $session_table;
    private static UserTable $user_table;

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

    public static function todo()
    {
        if (!isset(self::$todo_table)) {
            self::$todo_table = new TodoTable(self::get());
        }

        return self::$todo_table;
    }
    public static function user()
    {
        if (!isset(self::$user_table)) {
            self::$user_table = new UserTable(self::get());
        }

        return self::$user_table;
    }
    public static function session()
    {
        if (!isset(self::$session_table)) {
            self::$session_table = new SessionTable(self::get());
        }

        return self::$session_table;
    }
}
