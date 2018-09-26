<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include "controller/config.php";
    $new_user = [
        'username' => 'mark',
        'password' => 'test_pass_1'
    ];
    $new = new User($new_user);
    //print_r($new);
    echo PHP_EOL . PHP_EOL . PHP_EOL;
    $q = User::all();
    foreach($q as $line) print_r($line->attributes());
    print_r($q);
    $new->save();
    print_r($new);


?>
