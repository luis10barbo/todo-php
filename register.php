<?php
require_once(__DIR__ . "/db/connection.php");
include_once(__DIR__ . "/utils/redirect.php");
include_once(__DIR__ . "/utils/error.php");
include_once(__DIR__ . "/utils/session.php");
if (Database::user()->is_logged_in()) redirect_main_page();
function main()
{
    if (!isset($_POST["nickname"]) || !isset($_POST["password"])) return;

    $nickname = $_POST["nickname"];
    $password = $_POST["password"];

    $result = Database::user()->register($nickname, $password);
    if ($result === true) return redirect_main_page();
    if (is_error($result)) {
        $error = $result["message"];
        echo ("<p class='error-message'>$error</p>");
    }
}
main();
?>
<form action="" method="POST">
    <input id="nickname-input" type="text" name="nickname" value="luis10barbo" placeholder="Digite seu nick aqui">
    <input id="password-input" type="text" name="password" value="123123" placeholder=Digite sua senha aqui">
    <input type="submit" value="Registrar">
</form>