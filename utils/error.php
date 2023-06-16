<?php
function create_error(string $message, string $code = "")
{
    $error_message = ["type" => "error", "message" => $message];
    if (!empty($code)) $error_message["code"] = $code;

    return $error_message;
}

function is_error(array $var)
{
    if (!isset($var["type"])) return false;
    return $var["type"] === "error" ? true : false;
}
