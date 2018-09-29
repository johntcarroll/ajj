<?php

class User extends ActiveRecord\Model{

    static $table_name = 'users';

    public function login(){
        $conditions = [];
        $conditions[] = 'username = ? AND password = ?';
        $conditions[] = $this->username;
        $conditions[] = $this->encrypt_pass();

        return ($this->id ? $this : (static::find(['conditions' => $conditions] ?: FALSE)));
    }

    public function encrypt_pass(){
        // TODO salt and encrypt password
        return $this->password;
    }

}
