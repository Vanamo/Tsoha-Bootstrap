<?php

  $routes->get('/', function() {
    RecipeController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/loginHome', function() {
    HelloWorldController::loginHome();
  });
  
  $routes->post('/recipe', function() {
      RecipeController::store();
  });
  
  $routes->get('/recipe/addRecipe', function() {
      RecipeController::create();
  });  
   
  $routes->get('/recipe/:id', function($id){
      RecipeController::show($id); 
  }); 
  
  $routes->get('/signUp', function() {
    HelloWorldController::signUp();
  });
    
  $routes->get('/login', function() {
    HelloWorldController::login();
  });
      
  $routes->get('/shoppingList', function() {
    HelloWorldController::shoppingList();
  }); 
 
      
  $routes->get('/search', function() {
    HelloWorldController::search();
  });
