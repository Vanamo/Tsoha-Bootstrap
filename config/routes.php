<?php

  $routes->get('/', function() {
    RecipeController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
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
  
  $routes->get('/recipe/:id/edit', function($id){
  RecipeController::edit($id);
  });
  
  $routes->post('recipe/:id/edit', function($id) {
  RecipeController::update($id);
  });
  
  $routes->post('recipe/:id/destroy', function($id){
  RecipeController::destroy($id);
  });
  
  $routes->get('/signUp', function() {
    HelloWorldController::signUp();
  });
    
  $routes->get('/login', function() {
    UserController::login();
  });
  
  $routes->post('/login', function() {
      UserController::handle_login();
  });
  
  $routes->get('/user/loginHome', function() {
      UserController::showLoginHome();
  });
      
  $routes->get('/shoppingList', function() {
    HelloWorldController::shoppingList();
  }); 
 
      
  $routes->get('/search', function() {
    HelloWorldController::search();
  });
