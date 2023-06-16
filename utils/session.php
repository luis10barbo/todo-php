<?php
include(__DIR__ . "/echo.php");
require_once(__DIR__ . "/../db/connection.php");
function get_session_id()
{
    $session_id = session_id();
    if (!$session_id) {
        session_start();
        $session_id = session_id();
    }

    return session_id();
}

function _fetch_session_db(string $session_id)
{
    $db = Database::get();
    $statement = $db->query("SELECT * FROM sessao WHERE hashSessao = \"$session_id\"");
    return $statement->fetch();
}

function get_session_db(): array
{
    $session_id = get_session_id();

    $session = _fetch_session_db($session_id);
    if (!$session) {
        register_session_db($session_id);
        $session = _fetch_session_db($session_id);
    }
    return $session;
}

function register_session_db(string $session_id)
{

    $db = Database::get();
    $statement = $db->prepare("INSERT INTO sessao (hashSessao) VALUES (\"$session_id\")");
    $statement->execute();
}
function _insert_user_db(string $nickname, string $password): true | array
{
    $db = Database::get();
    $register = $db->prepare("INSERT INTO 'usuario' (nickname, senha) VALUES (:nickname, :password)");
    try {
        return $register->execute(["nickname" => $nickname, "password" => $password]);
    } catch (PDOException $e) {
        if ($e->getCode() === "23000") {
            return create_error("Usuario ja existe");
        }
    }
}
function _select_user_db(string $nickname, bool $selectSensitiveData = true): array | false
{
    $sql = "SELECT idUsuario, nickname" . ($selectSensitiveData ? ", senha" : "") . " FROM usuario WHERE nickname = :nickname";
    $db = Database::get();
    $statement = $db->prepare("$sql");
    $statement->execute(array("nickname" => $nickname));
    return $statement->fetch(PDO::FETCH_ASSOC);
}
function _select_user_by_id(string $user_id, bool $selectSensitiveData = true): array | false
{
    $sql = "SELECT idUsuario, nickname" . ($selectSensitiveData ? ", senha" : "") . " FROM usuario WHERE idUsuario = :user_id";
    $db = Database::get();
    $statement = $db->prepare("$sql");
    $statement->execute(array("user_id" => $user_id));
    return $statement->fetch(PDO::FETCH_ASSOC);
}
function _set_user_session_db(int | null $id_usuario, string $hash_sessao)
{
    $db = Database::get();
    $statement = $db->prepare("UPDATE sessao SET idUsuario = :id_usuario WHERE hashSessao = :hash_sessao");
    return $statement->execute(array("id_usuario" => $id_usuario, "hash_sessao" => $hash_sessao));
}
function register_user_db(string $nickname, string $password)
{
    $hashed_password = password_hash(password: $password, algo: PASSWORD_BCRYPT);
    $insert_result = _insert_user_db($nickname, $hashed_password);

    if ($insert_result !== true) {
        return $insert_result;
    }
    return login_user_db($nickname, $password);
}
function login_user_db(string $nickname, string $password)
{
    $session = get_session_db();
    $user = _select_user_db($nickname);

    if (!password_verify($password, $user["senha"])) return;

    return _set_user_session_db($user["idUsuario"], $session["hashSessao"]);
}
function is_logged_in()
{
    return empty(get_session_db()["idUsuario"]);
}
function get_user_info()
{
    $session = get_session_db();
    $user_id = $session["idUsuario"];
    if (empty($user_id)) return null;

    $user = _select_user_by_id($user_id, false);
    if (!$user) return null;
    return $user;
}
function logout()
{
    $session = get_session_db();
    _set_user_session_db(null, $session["hashSessao"]);
}
