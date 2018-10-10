<?php
    $class = $_REQUEST['class'];
    unset($_REQUEST['class']);
    $fn = $_REQUEST['fn'];
    unset($_REQUEST['fn']);
    $response = $class::$fn($_REQUEST);
    echo json_encode($response);
