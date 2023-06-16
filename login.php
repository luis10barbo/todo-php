<?php
include(__DIR__ . "/utils/session.php");
include_once(__DIR__ . "/utils/redirect.php");


if (Database::user()->is_logged_in()) redirect_main_page();
?>
<form action="" method="POST">
    <input id="nickname-input" type="text" name="nickname" value="luis10barbo" placeholder="Digite seu nick aqui">
    <input id="password-input" type="text" name="password" value="123123" placeholder=Digite sua senha aqui">
    <input type="submit" value="Logar">
</form>
<?php
require_once(__DIR__ . "/db/connection.php");
include(__DIR__ . "/utils/error.php");

if (!isset($_POST["nickname"]) || !isset($_POST["password"])) return;

$nickname = $_POST["nickname"];
$password = $_POST["password"];

if (!$nickname || !$password) return;

$result = Database::user()->login($nickname, $password);
if ($result) redirect_main_page();
?>