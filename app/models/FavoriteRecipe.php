<?php

class FavoriteRecipe extends BaseModel {

    public $recipe_id, $customer_id, $name;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public function saveFavorite() {
        $recipe_id = $this->recipe_id; 
        $customer_id = $this->customer_id;
        $query = DB::connection()->prepare('INSERT INTO Favoriterecipe (recipe_id, customer_id) VALUES (:recipe_id, :customer_id)');
        $query->execute(array('recipe_id' => $recipe_id, 'customer_id' => $customer_id));
    }

    public static function find($customer_id) {
        $query = DB::connection()->prepare('SELECT Favoriterecipe.recipe_id, Favoriterecipe.customer_id, Recipe.name AS name FROM Favoriterecipe INNER JOIN Recipe ON Favoriterecipe.recipe_id = Recipe.id WHERE Favoriterecipe.customer_id = :customer_id');
        $query->execute(array('customer_id' => $customer_id));
        $rows = $query->fetchAll();
        $favoriteRecipes = array();

        foreach ($rows as $row) {
            $favoriteRecipes[] = new FavoriteRecipe(array(
                'recipe_id' => $row['recipe_id'],
                'customer_id' => $row['customer_id'],
                'name' => $row['name']
            ));
        }
        return $favoriteRecipes;
    }
    
    public function check_if_favorite() {
        $recipe_id = $this->recipe_id;
        $customer_id = $this->customer_id;
        $query = DB::connection()->prepare('SELECT recipe_id FROM Favoriterecipe WHERE recipe_id = :recipe_id AND customer_id = :customer_id LIMIT 1');
        $query->execute(array('recipe_id' => $recipe_id, 'customer_id' => $customer_id));
        $row = $query->fetch();
        if ($row) {
           return true; 
        } else {
           return false;
        };
    }

    public function destroy() {
        $recipe_id = $this->recipe_id;
        $customer_id = $this->customer_id;
        $query = DB::connection()->prepare('DELETE FROM Favoriterecipe WHERE recipe_id = :recipe_id AND customer_id = :customer_id');
        $query->execute(array('recipe_id' => $recipe_id, 'customer_id' => $customer_id));
    }

}
