<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include "controller/config.php";

    $search = User::find(1);

    echo $search->username . PHP_EOL;
    echo $search->return_username();



?>
