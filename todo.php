<?php
    require_once(__DIR__."/utils/redirect.php");
    require_once(__DIR__."/db/connection.php");

    if (!Database::user()->is_logged_in()) redirect_main_page();
