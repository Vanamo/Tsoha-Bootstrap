<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	View::make('/suunnitelmat/home.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      echo ('helloworld.html');
    }

    public static function loginHome(){
   	View::make('/suunnitelmat/loginHome.html');
    }
    
    public static function addRecipe(){
        View::make('suunnitelmat/addRecipe.html');
    }
    
    public static function signUp(){
    View::make('suunnitelmat/signUp.html');
    }
    
    public static function login(){
    View::make('suunnitelmat/login.html');
    }
        
    public static function shoppingList(){
    View::make('suunnitelmat/shoppingList.html');
    }
            
    public static function recipe(){
    View::make('suunnitelmat/recipe.html');
    }
            
    public static function search(){
    View::make('suunnitelmat/search.html');
    }
}
