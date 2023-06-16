<?php
class UserTable
{
    private static PDO $db;
    function __construct(PDO $db)
    {
        self::$db = $db;
    }
    private function insert_user(string $nickname, string $password): true | array
    {
        $register = self::$db->prepare("INSERT INTO 'usuario' (nickname, senha) VALUES (:nickname, :password)");
        try {
            return $register->execute(["nickname" => $nickname, "password" => $password]);
        } catch (PDOException $e) {
            if ($e->getCode() === "23000") {
                return create_error("Usuario ja existe");
            }
        }
    }
    private function select_user(string $nickname, bool $selectSensitiveData = true): array | false
    {
        $sql = "SELECT idUsuario, nickname" . ($selectSensitiveData ? ", senha" : "") . " FROM usuario WHERE nickname = :nickname";
        $statement = self::$db->prepare("$sql");
        $statement->execute(array("nickname" => $nickname));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    private function select_user_by_id(string $user_id, bool $selectSensitiveData = true): array | false
    {
        $sql = "SELECT idUsuario, nickname" . ($selectSensitiveData ? ", senha" : "") . " FROM usuario WHERE idUsuario = :user_id";
        $statement = self::$db->prepare("$sql");
        $statement->execute(array("user_id" => $user_id));
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function register(string $nickname, string $password)
    {
        $hashed_password = password_hash(password: $password, algo: PASSWORD_BCRYPT);
        $insert_result = self::insert_user($nickname, $hashed_password);

        if ($insert_result !== true) {
            return $insert_result;
        }
        return self::login($nickname, $password);
    }
    function login(string $nickname, string $password): true | array
    {
        $session = Database::session()->get_session();
        $user = self::select_user($nickname);
        if (!$user) return create_error("Usuario nao encontrado");
        if (!password_verify($password, $user["senha"])) return create_error("Nick ou Credenciais incorretas.");

        return Database::session()->set_session_user($user["idUsuario"], $session["hashSessao"]);
    }
    function is_logged_in()
    {
        return !empty(Database::session()->get_session()["idUsuario"]);
    }
    function get_user_info()
    {
        $session = Database::session()->get_session();
        $user_id = $session["idUsuario"];
        if (empty($user_id)) return null;

        $user = self::select_user_by_id($user_id, false);
        if (!$user) return null;
        return $user;
    }
    function logout()
    {
        $session = Database::session()->get_session();
        Database::session()->set_session_user(null, $session["hashSessao"]);
    }
}
