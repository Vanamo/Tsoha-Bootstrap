<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();
        foreach ($this->validators as $validator) {
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
            $errors = array_merge($errors, $this->{$validator}());
        }
        return $errors;
    }

    public function validate_string_length($string, $length, $field_name) {
        $errors = array();
        if ($string == '' || $string == null) {
            $errors[] = $field_name . ': Ei saa olla tyhjä!';
        }
        if (strlen($string) < $length) {
            $errors[] = $field_name . ': Tulee olla vähintään ' . $length . ' merkkiä pitkä!';
        }
        return $errors;
    }
    
    public function validate_amount($array, $amount, $field_name) {
        $errors = array();
        
        if (count($array) < $amount) {
            $errors[] = $field_name . ' tulee olla vähintään ' . $amount;
        }
        return $errors;
    }
    
    public function validate_individual($name, $id, $table) {
        $errors = array();
        //Jos alkio on uusi (ei vielä tietokannassa), annetaan sille väliaikainen id -1 
        if (is_null($id)) {$id = -1;}

        $query = DB::connection()->prepare('SELECT name FROM ' . $table . ' WHERE name = :name AND id != :id LIMIT 1');
        $query->execute(array('name' => $name, 'id' => $id));
        $row = $query->fetch();

        if ($row) { 
            $errors[] = 'Nimi on jo käytössä';
        }
        return $errors;
    }
}
