<?php

class RecipeController extends BaseController{
    public static function index(){
        //Haetaan kaikki reseptit tietokannasta
        $recipes = Recipe::all();
        View::make('recipe/home.html', array('recipes' => $recipes));
    }
    
    public static function show($id){
        //Haetaan tietty resepti tietokannasta
        $recipe = Recipe::find($id);
        $ingredientsOfARecipe = Recipe::findIngredientsOfARecipe($id);
        $tagsOfARecipe = Recipe::findTagsOfARecipe($id);
        //Kint::dump($tagsOfARecipe);
        View::make('recipe/recipe.html', array('recipe' => $recipe, 
            'ingredientsOfARecipe' => $ingredientsOfARecipe,
            'tagsOfARecipe' => $tagsOfARecipe));
    }
    
    public static function create(){
        $ingredients = Ingredient::all();
        $tags = Tag::all();
        $units = Unit::all();
        View::make('recipe/addRecipe.html', array('ingredients' => $ingredients, 
            'tags' => $tags, 'units' => $units));
    }
    
    public static function store(){
        $params = $_POST;
        $user = self::get_user_logged_in();
        $attributes = array(
            'name' => $params['name'],
            'customer_id' => $user->id,
            'instructions' => $params['instructions']
        );

        $recipe = new Recipe($attributes);
        $errors = $recipe->errors();

        if (count($errors) == 0) {
            //Kint::dump($errors);
            $recipe->save();                
            Redirect::to('/recipe/' . $recipe->id, array('message' => 'Resepti on lisätty Keittokirjaan'));

        } else {  
            View::make('/recipe/addRecipe.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    public static function edit($id) {
        //lomakkeen esittäminen
        $recipe = Recipe::find($id);
        $ingredientsOfARecipe = Recipe::findIngredientsOfARecipe($id);
        $tagsOfARecipe = Recipe::findTagsOfARecipe($id);
        View::make('recipe/edit.html', array('attributes' => $recipe, 
            'ingredientsOfARecipe' => $ingredientsOfARecipe, 
            'tagsOfARecipe' => $tagsOfARecipe));
    }

    public static function update($id) {
        //lomakkeen käsittely
        $params = $_POST;
        
        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'instructions' => $params['instructions']
        );
        
        $recipe = new Recipe($attributes);
        $errors = $recipe->errors();
        
        if (count($errors) > 0) {
            View::make('recipe/edit.html', array('errors' => $errors, 'attributes' => $attributes));            
        } else {
            $recipe->update();
            
            Redirect::to('/recipe/' . $recipe->id, array('message' => 'Reseptiä on muokattu onnistuneesti'));
        }
    }
    
    public static function destroy($id) {
        $recipe = new Recipe(array('id' => $id));
        $recipe->destroy();
        
        Redirect::to('/', array('message' => 'Resepti on poistettu onnistuneesti'));
    }
}
