<?php
function dump_formated($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}

function dump_formated_json($var)
{

    echo "<pre>";
    echo json_encode($var);
    echo "</pre>";
}
