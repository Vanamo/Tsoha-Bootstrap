<?php

  class Recipe extends BaseModel{

    public $id, $customer_id, $name, $instructions;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM Recipe');
        $query->execute();
        $rows = $query->fetchAll();
        $recipes = array();

        foreach($rows as $row) {
            $recipes[] = new Recipe(array(
                'id' => $row['id'],
                'customer_id' => $row['customer_id'],
                'name' => $row['name'],
                'instructions' => $row['instructions']
            ));
        }    
        
        return $recipes;

    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Recipe WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row) {
            $recipe = new Recipe(array(
                'id' => $row['id'],
                'customer_id' => $row['customer_id'],
                'name' => $row['name'],
                'instructions' => $row['instructions']                
            ));
        }
        return $recipe;
    }
    
    public static function findIngredientsOfARecipe($id) {
        $query = DB::connection()->prepare('SELECT Ingredientofarecipe.amount, Ingredient.name AS ingredient_name, Unit.name AS unit_name, Ingredientofarecipe.listorder FROM Ingredientofarecipe INNER JOIN Unit ON Unit.id = Ingredientofarecipe.unit_id INNER JOIN Ingredient ON Ingredient.id = Ingredientofarecipe.ingredient_id WHERE recipe_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query -> fetchAll();
        Kint::dump($rows);
        $ingredients = array();
        
        foreach ($rows as $row) {
            $ingredients[] = new IngredientOfARecipe(array(
                'amount' => $row['amount'],
                'ingredientName' => $row['ingredient_name'],
                'unitName' => $row['unit_name'],
                'listOrder' => $row['listorder']
            ));            
        }
        Kint::dump($ingredients);
        return $ingredients;
        
    }
        
    public static function findUserRecipes($customer_id) {
        $query = DB::connection()->prepare('SELECT * FROM Recipe WHERE customer_id = :customer_id');
        $query->execute(array('customer_id' => $customer_id));
        $rows = $query->fetchAll();
        $userRecipes = array();
        
        foreach($rows as $row) {
            $userRecipes[] = new Recipe(array(
                'id' => $row['id'],
                'customer_id' => $row['customer_id'],
                'name' => $row['name'],
                'instructions' => $row['instructions']                
            ));
        }
        return $userRecipes;
    }
    
    public static function findFavoriteRecipes($customer_id) {
        $query = DB::connection()->prepare('SELECT * FROM FavoriteRecipe WHERE customer_id = :customer_id');
        $query->execute(array('customer_id' => $customer_id));
        $rows = $query->fetchAll();
        $favoriteRecipes = array();
        
        foreach($rows as $row) {
            $favoriteRecipes = new Recipe(array(
                'recipe_id' => $row['recipe_id'],
                'customer_id' => $row['customer_id']             
            ));
        }
        return $favoriteRecipes;        
    }
        
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Recipe (name, instructions) VALUES (:name, :instructions) RETURNING id');
        $query->execute(array('name' => $this->name, 'instructions' => $this->instructions));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public static function findTagsOfARecipe($id) {
        $query = DB::connection()->prepare('SELECT * FROM TagOfARecipe WHERE recipe_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query -> fetchAll();
        $tagsOfARecipe = array();
        
        foreach ($rows as $row) {
            $tagsOfARecipe[] = new TagOfARecipe(array(
                'recipe_id' => $row['recipe_id'],
                'tag_id' => $row['tag_id']
            ));            
        }
        return $tagsOfARecipe;        
    }

    public function validate_name() {
        return $this->validate_string_length($this->name, 3, 'Reseptin nimi');
    }
    
    public function update(){
        $query = DB::connection()->prepare('UPDATE Recipe SET name = :name, instructions = :instructions 
            WHERE id = :id');
        $query->execute(array(
            'id' => $this->id,
            'name' => $this->name, 
            'instructions' => $this->instructions));
    }
    
    public function destroy() {
        $id = $this->id;
        $query = DB::connection()->prepare('DELETE FROM Recipe WHERE id = :id');
        $query->execute(array('id' => $id));
    }
}


