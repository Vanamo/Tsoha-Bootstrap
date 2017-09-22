<?php

  class Recipe extends BaseModel{

    public $id, $customer_id, $name, $instructions;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
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
        $query = DB::connection()->prepare('SELECT * FROM IngredientOfARecipe WHERE recipe_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query -> fetchAll();
        $ingredientsOfARecipe = array();
        
        foreach ($rows as $row) {
            $ingredientsOfARecipe[] = new IngredientOfARecipe(array(
                'recipe_id' => $row['recipe_id'],
                'ingredient_id' => $row['ingredient_id'],
                'unit_id' => $row['unit_id'],
                'amount' => $row['amount'],
                'listOrder' => $row['listorder']
            ));            
        }
        return $ingredientsOfARecipe;
        
    }
        
    public static function findByCustomer($customer_id) {
        $query = DB::connection()->prepare('SELECT * FROM Recipe WHERE customer_id = :customer_id LIMIT 1');
        $query->execute(array('customer_id' => $customer_id));
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
        
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Recipe (name, instructions) VALUES (:name, :instructions) RETURNING id');
        $query->execute(array('name' => $this->name, 'instructions' => $this->instructions));
        $row = $query->fetch();
        //Kint::trace();
        //Kint::dump($row);
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

}


