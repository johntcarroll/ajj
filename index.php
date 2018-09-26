<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include "controller/config.php";
    $new_user = [
        'username' => 'mark',
        'password' => 'test_pass_1'
    ];
    $new = new User($new_user);
    echo $new->return_username();
    //print_r($new);
    echo "<br /><br /><br />";
    $q = User::all();
    foreach($q as $line) print_r($line->attributes());
    echo "<br /><br /><br />";
    $new->save();
    print_r($new);


?>
