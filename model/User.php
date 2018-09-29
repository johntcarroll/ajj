<?php

class User extends ActiveRecord\Model{

    static $table_name = 'users';

    public function login(){
        print_r($this);
        $attempt = static::find([
            'conditions' => [
                'username = ? AND password = ?',
                $this->username,
                $this->encrypt_pass()
            ]
        ]);

        return ($attempt ?: FALSE);
    }

    public function encrypt_pass(){
        // TODO salt and encrypt password
        return $this->password;
    }

}
