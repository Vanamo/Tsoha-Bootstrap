<?php

  $routes->get('/', function() {
    UserController::index();
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
  
  $routes->post('/recipe/:id/edit', function($id) {
  RecipeController::update($id);
  });
  
  $routes->post('/recipe/:id/destroy', function($id){
  RecipeController::destroy($id);
  });
  
  $routes->post('/recipe/:id/addFavorite', function($id) {
  UserController::storeFavorite($id);
  });
    
  $routes->post('/recipe/:id/removeFavorite', function($id) {
  UserController::destroyFavorite($id);
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
  
  $routes->post('/logout', function() {
    UserController::logout();
  });
  
  $routes->get('/user/:id/loginHome', function($id) {
    UserController::showLoginHome($id);
  });
      
  $routes->get('/shoppingList', function() {
    HelloWorldController::shoppingList();
  }); 
 
      
  $routes->get('/search', function() {
    HelloWorldController::search();
  });
