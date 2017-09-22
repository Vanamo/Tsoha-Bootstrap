<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	View::make('/recipe/home.html');
    }

    public static function sandbox(){
      $recipes = Recipe::all();
      Kint::dump($recipes);
    }

    public static function loginHome(){
   	View::make('/recipe/loginHome.html');
    }
    
    public static function addRecipe(){
        View::make('recipe/addRecipe.html');
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
    View::make('recipe/recipe.html');
    }
            
    public static function search(){
    View::make('suunnitelmat/search.html');
    }
}
