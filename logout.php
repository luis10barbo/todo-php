<?php
include(__DIR__ . "/utils/session.php");
Database::user()->logout();
header("Location: /hellow");
