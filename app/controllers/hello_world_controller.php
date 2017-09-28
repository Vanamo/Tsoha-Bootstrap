<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	View::make('/recipe/home.html');
    }

    public static function sandbox(){
      $piirakka = new Recipe(array('name' => 'ma'));
      $errors = $piirakka->errors();
      Kint::dump($errors);
    }

        
    public static function shoppingList(){
    View::make('suunnitelmat/shoppingList.html');
    }

            
    public static function search(){
    View::make('suunnitelmat/search.html');
    }
}
