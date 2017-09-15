<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/loginHome', function() {
    HelloWorldController::loginHome();
  });
  
  $routes->get('/addRecipe', function() {
    HelloWorldController::addRecipe();
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
    
  $routes->get('/recipe', function() {
    HelloWorldController::recipe();
  });
      
  $routes->get('/search', function() {
    HelloWorldController::search();
  });