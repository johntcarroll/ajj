<?php
    include "config.php";
    $u = $_POST['user'];
    $p = $_POST['pass'];
    session_start();
    $id = new User([
        'username' => $u,
        'password' => $p
    ]);
    if($id->login()){
        $_SESSION['user'] = $id->id;
        session_write_close();
        header('Location: ../view/home.php');
    }else{
        session_write_close();
        header('Location: ../index.php?m=failed');
    }
