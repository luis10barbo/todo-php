<?php
function create_error(string $message, string $code = "")
{
    $error_message = ["type" => "error", "message" => $message];
    if (!empty($code)) $error_message["code"] = $code;

    return $error_message;
}
