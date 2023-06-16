<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo APP</title>
</head>
<script>
    function register() {
        document.querySelector("#nickname-input");
    }
</script>

<body>
    <div>

        <?php
        include_once(__DIR__ . "/db/connection.php");
        $user = Database::user()->get_user_info();
        if (!$user) {
            echo "
            <a href=\"register.php\">Registrar-se</a>
            <a href=\"login.php\">Logar</a>
            ";
        } else {
            $nickname = $user["nickname"];
            echo "
            Ola $nickname, bem vindo ao CRUD TODO APP
            <a href=\"logout.php\">Deslogar</a>
            <a href=\"todo.php\">Acessar lista de fazeres</a>
            ";
        }

        ?>


        <?php
        require_once(__DIR__ . "/db/connection.php");
        include_once(__DIR__ . "/utils/echo.php");
        include_once(__DIR__ . "/utils/session.php");
        ?>
    </div>
</body>

</html>