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
