<?php
class TodoTable
{
    private static PDO $db;
    function __construct(PDO $db)
    {
        self::$db = $db;
    }
    function getAll()
    {

        self::$db->query("SELECT * FROM todo WHERE idUsuario");
    }
}
