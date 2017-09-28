<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();
      $validator_errors = array();

        foreach($this->validators as $validator){
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
            $validator_errors[] = $this->{$validator}();
            Kint::dump($validator_errors);
            //TÄMÄ PITÄÄ SAADA TOIMIMAAN OIKEIN!
            array_merge($errors, $validator_errors);
        }

      return $errors;
    }
    
        
    public function validate_string_length($string, $length){
        $errors = array();
        //$pituus = strlen($length);
        if ($string == '' || $string == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($length) < 3) {
            $errors[] = 'Nimen pituuden tulee olla vähintään kolme merkkiä';
        }
        //Kint::dump($errors, $string, $length, $pituus);
        return $errors;
    }

  }
