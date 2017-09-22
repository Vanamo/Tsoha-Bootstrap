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
        $recipe = new Recipe(array(
            'name' => $params['name'],
            'instructions' => $params['instructions']
        ));
        
        Kint::dump($params);
        
        $recipe->save();
        
        Redirect::to('/recipe/' . $recipe->id, array('message' => 'Resepti on lisätty Keittokirjaan'));
    }

}
