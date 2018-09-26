<?php

class User extends ActiveRecord\Model{

    static $table_name = 'users';

    public function return_username(){
        $value = "The username is: " . $this->username;
        return $value;
    }

}
