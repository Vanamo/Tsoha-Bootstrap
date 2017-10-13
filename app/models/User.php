<?php

class User extends BaseModel {

    public $id, $name, $password_hash, $password_check, $salt;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_password_length',
            'validate_username_length',
            'validate_individual_username',
            'validate_password_check');
    }

    public static function authenticate($name, $password_hash) {
        $query = DB::connection()->prepare('SELECT * FROM Customer WHERE name = :name AND password_hash = :password_hash LIMIT 1');
        $query->execute(array('name' => $name, 'password_hash' => $password_hash));
        $row = $query->fetch();

        if ($row) {
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

        if ($row) {
            $user = new User(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password_hash' => $row['password_hash'],
                'salt' => $row['salt']
            ));
        }
        return $user;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Customer (name, password_hash) VALUES (:name, :password_hash) RETURNING id');
        $query->execute(array('name' => $this->name, 'password_hash' => $this->password_hash));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public static function findUserRecipes($customer_id) {
        $query = DB::connection()->prepare('SELECT * FROM Recipe WHERE customer_id = :customer_id');
        $query->execute(array('customer_id' => $customer_id));
        $rows = $query->fetchAll();
        $userRecipes = array();

        foreach ($rows as $row) {
            $userRecipes[] = new Recipe(array(
                'id' => $row['id'],
                'customer_id' => $row['customer_id'],
                'name' => $row['name'],
                'instructions' => $row['instructions']
            ));
        }
        return $userRecipes;
    }

    public function update_password() {
        $query = DB::connection()->prepare('UPDATE Customer SET password_hash = :password_hash
                WHERE id = :id');
        $query->execute(array(
            'id' => $this->id,
            'password_hash' => $this->password_hash));
    }

    public function destroy() {
        $id = $this->id;

        $query = DB::connection()->prepare('DELETE FROM Favoriterecipe WHERE customer_id = :id');
        $query->execute(array('id' => $id));

        $query2 = DB::connection()->prepare('UPDATE Recipe SET customer_id = NULL WHERE customer_id = :id');
        $query2->execute(array('id' => $id));

        $query3 = DB::connection()->prepare('DELETE FROM Customer WHERE id = :id');
        $query3->execute(array('id' => $id));
    }

    public function validate_password_length() {
        return $this->validate_string_length($this->password_hash, 5, 'Salasana');
    }

    public function validate_username_length() {
        return $this->validate_string_length($this->name, 3, 'Käyttäjätunnus');
    }

    public function validate_individual_username() {
        $table = 'Customer';
        return $this->validate_individual($this->name, $this->id, $table);
    }

    public function validate_password_check() {
        $errors = array();
        $string1 = $this->password_check;
        $string2 = $this->password_hash;
        if (is_null($string1)) {
            return $errors;
        }        
        if (strcmp($string1, $string2) !== 0) {
            $errors[] = 'Salasanat eivät täsmää';
        }
        return $errors;
    }

}
