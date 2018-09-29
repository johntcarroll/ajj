<?php
    session_start();
    unset($_SESSION['user']);
    session_write_close();
    header('Location: ../index.php');
