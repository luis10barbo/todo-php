<?php
require_once(__DIR__ . "/../../utils/session.php");
class SessionTable
{
    private static PDO $db;
    function __construct(PDO $db)
    {
        self::$db = $db;
    }
    private function select_session(string $session_id)
    {
        $db = Database::get();
        $statement = $db->query("SELECT * FROM sessao WHERE hashSessao = \"$session_id\"");
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    private function insert_session(string $session_id)
    {
        $db = Database::get();
        $statement = $db->prepare("INSERT INTO sessao (hashSessao) VALUES (\"$session_id\")");
        $statement->execute();
    }
    function get_session(): array
    {
        $session_id = get_session_id();

        $session = self::select_session($session_id);
        if (!$session) {
            self::insert_session($session_id);
            $session = self::select_session($session_id);
        }
        return $session;
    }
    function set_session_user(int | null $id_usuario, string $hash_sessao)
    {
        $db = Database::get();
        $statement = $db->prepare("UPDATE sessao SET idUsuario = :id_usuario WHERE hashSessao = :hash_sessao");
        return $statement->execute(array("id_usuario" => $id_usuario, "hash_sessao" => $hash_sessao));
    }
}
