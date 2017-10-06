<?php

class RecipeController extends BaseController {

    public static function show($id) {
//Haetaan tietty resepti tietokannasta
        $recipe = Recipe::find($id);
        $ingredientsOfARecipe = IngredientOfARecipe::findIngredientsOfARecipe($id);
        $tagsOfARecipe = TagOfARecipe::findTagsOfARecipe($id);

        View::make('recipe/recipe.html', array('recipe' => $recipe,
            'ingredientsOfARecipe' => $ingredientsOfARecipe,
            'tagsOfARecipe' => $tagsOfARecipe));
    }

    public static function create() {
        self::check_logged_in();
        $ingredients = Ingredient::all();
        $tags = Tag::all();
        $units = Unit::all();
        View::make('recipe/addRecipe.html', array('ingredients' => $ingredients,
            'tags' => $tags, 'units' => $units));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        $user = self::get_user_logged_in();
        $tags = array();
        if (isset($params['tags'])) {
            $tags = $params['tags'];
        }
        $ingredients = $params['ingredients'];
        $amounts = $params['amounts'];
        $units = $params['units'];
        $attributes = array(
            'customer_id' => $user->id,
            'name' => $params['name'],
            'instructions' => $params['instructions'],
            'tags' => array()
        );

        foreach ($tags as $tag) {
            $attributes['tags'][] = $tag;
        }
        for ($i = 0; $i < count($ingredients); $i++) {
            if ($ingredients[$i] == -1) {
                continue;
            }
            $attributes['ingredients'][] = $ingredients[$i];
            $attributes['amounts'][] = $amounts[$i];
            $attributes['units'][] = $units[$i];
        }

        $recipe = new Recipe($attributes);
//        $errors = $recipe->errors();
//
//        if (count($errors) == 0) {
        $recipe->save();
        Redirect::to('/recipe/' . $recipe->id, array('message' => 'Resepti on lisätty Keittokirjaan'));
//        } else {
//            $ingredients = Ingredient::all();
//            $tags = Tag::all();
//            $units = Unit::all();
//            View::make('/recipe/addRecipe.html', array('errors' => $errors, 'attributes' => $attributes,
//                'ingredients' => $ingredients, 'tags' => $tags, 'units' => $units));
//        }
    }

    public static function edit($id) {
//lomakkeen esittäminen
        self::check_logged_in();
        $recipe = Recipe::find($id);
        $ingredientsOfARecipe = IngredientOfARecipe::findIngredientsOfARecipe($id);
        $tagsOfARecipe = TagOfARecipe::findTagsOfARecipe($id);
        $ingredients = Ingredient::all();
        $tags = Tag::all();
        $units = Unit::all();
        View::make('recipe/edit.html', array('attributes' => $recipe,
            'ingredientsOfARecipe' => $ingredientsOfARecipe,
            'tagsOfARecipe' => $tagsOfARecipe, 'ingredients' => $ingredients,
            'tags' => $tags, 'units' => $units));
    }

    public static function update($id) {
//lomakkeen käsittely
        $params = $_POST;
        $tags = array();
        if (isset($params['tags'])) {
            $tags = $params['tags'];
        }
        $ingredients = $params['ingredients'];
        $amounts = $params['amounts'];
        $units = $params['units'];
        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'instructions' => $params['instructions'],
            'tags' => array()
        );

        foreach ($tags as $tag) {
            $attributes['tags'][] = $tag;
        }
        for ($i = 0; $i < count($ingredients); $i++) {
            if ($ingredients[$i] == -1) {
                continue;
            }
            $attributes['ingredients'][] = $ingredients[$i];
            $attributes['amounts'][] = $amounts[$i];
            $attributes['units'][] = $units[$i];
        }

        $recipe = new Recipe($attributes);
        //VALIDOINNEISTA EI VOI KÄYTTÄÄ MUUTA KUIN NIMEN PITUUDEN VALIDOINTIA
//        $errors = $recipe->errors();
//        if (count($errors) > 0) {
//            $ingredients = Ingredient::all();
//            $tags = Tag::all();
//            $units = Unit::all();
//            View::make('recipe/edit.html', array('errors' => $errors, 'attributes' => $attributes,
//                'ingredients' => $ingredients, 'tags' => $tags, 'units' => $units));
//        } else {
        $recipe->update();

        Redirect::to('/recipe/' . $recipe->id, array('message' => 'Reseptiä on muokattu onnistuneesti'));
    }

    public static function destroy($id) {
        self::check_logged_in();
        $recipe = new Recipe(array('id' => $id));
        $recipe->destroy();

        Redirect::to('/', array('message' => 'Resepti on poistettu onnistuneesti'));
    }

    public static function destroyIngredient($id_r, $id_i) {
        $ingredientOfARecipe = new IngredientOfARecipe(array('id' => $id_i));
        $ingredientOfARecipe->destroy();

        $this->edit($id_r);
    }

}
