<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include "controller/config.php";

    $query_params = [
        'conditions' => [
            'username LIKE ?',
            'jcarroll'
        ]
    ]
    $search = User::all([
        'conditions' => [
            'username LIKE ?',
            'jcarroll'
        ],
        'order' => 'id asc'
    ]);

    foreach($search as $db_row){
        print_r($db_row);
    }



?>
