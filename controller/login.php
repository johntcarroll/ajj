<?php
    include "config.php";
    $u = $_POST['user'];
    $p = $_POST['pass'];
    session_start();
    $id = new User([
        'username' => $u,
        'password' => $p
    ]);
    $attempt = $id->login();
    if($attempt){
        $_SESSION['user'] = $attempt->id;
        session_write_close();
        header('Location: ../view/app.php');
    }else{
        session_write_close();
        header('Location: ../index.php?m=failed');
    }
