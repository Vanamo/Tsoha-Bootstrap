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
  
  $routes->post('/recipe/:id_r/:id_i/destroyIngredient', function($id_r, $id_i) {
  RecipeController::destroyIngredient($id_r, $id_i);
  });
  
  $routes->post('/recipe/:id/addFavorite', function($id) {
  UserController::storeFavorite($id);
  });
    
  $routes->post('/recipe/:id/removeFavorite', function($id) {
  UserController::destroyFavorite($id);
  });
  
  $routes->get('/signUp', function() {
    UserController::signUp();
  });
    
  $routes->post('/signUp', function() {
    UserController::handle_signUp();
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
  
  $routes->get('/user/:id/changePassword', function($id) {
    UserController::changePassword($id);
  });
    
  $routes->post('/user/:id/changePassword', function($id) {
    UserController::updatePassword($id);
  });
  
  $routes->get('/shoppingList', function() {
    HelloWorldController::shoppingList();
  }); 
 
      
  $routes->get('/search', function() {
    HelloWorldController::search();
  });
