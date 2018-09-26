<?php
    include $root . "controller/config.php";
    // check for login
    if(empty($_SESSION['user'])){
        session_start();
        session_write_close();
        header('Location: ' . $root . "logout.php");
    }else{
        $loggedInUser = User::find($_SESSION['user']);
    }
 ?>
<html>
    <head>
        
    </head>
    <body>
