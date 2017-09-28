<?php

class User extends BaseModel{

    public $id, $name, $password_hash, $salt;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        //$this->validators = array('validate_name'); TOTEUTA VALIDOINTI
    }
    
    public static function authenticate($name, $password_hash) {
        $query = DB::connection()->prepare('SELECT * FROM Customer WHERE name = :name AND password_hash = :password_hash LIMIT 1');
        $query->execute(array('name' => $name, 'password_hash' => $password_hash));
        $row = $query->fetch();
        
        if($row) {
            $user = new User(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password_hash' => $row['password_hash'],
                'salt' => $row['salt']
            ));
            return $user;
        } else {
            return null;
        }
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Customer WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row) {
            $user = new User(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password_hash' => $row['password_hash'],
                'salt' => $row['salt']              
            ));
        }
        return $user;
    }
}    
