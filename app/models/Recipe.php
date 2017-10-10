<?php

class Recipe extends BaseModel {

    public $id, $customer_id, $name, $instructions, $tags, $ingredients, $amounts, $units;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name_length',
            'validate_individual_name',
            'validate_ingredient_amount');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Recipe');
        $query->execute();
        $rows = $query->fetchAll();
        $recipes = array();

        foreach ($rows as $row) {
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

        if ($row) {
            $recipe = new Recipe(array(
                'id' => $row['id'],
                'customer_id' => $row['customer_id'],
                'name' => $row['name'],
                'instructions' => $row['instructions']
            ));
        }
        return $recipe;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Recipe (customer_id, name, instructions) VALUES (:customer_id, :name, :instructions) RETURNING id');
        $query->execute(array('customer_id' => $this->customer_id, 'name' => $this->name, 'instructions' => $this->instructions));
        $row = $query->fetch();
        $this->id = $row['id'];

        $tags = $this->tags;
        foreach ($tags as $tag) {
            $query = DB::connection()->prepare('INSERT INTO Tagofarecipe (recipe_id, tag_id) VALUES (:id, :tag)');
            $query->execute(array('id' => $this->id, 'tag' => $tag));
        }

        $ingredients = $this->ingredients;
        $amounts = $this->amounts;
        $units = $this->units;
        for ($i = 0; $i < count($units); $i++) {
            $query2 = DB::connection()->prepare('INSERT INTO Ingredientofarecipe (recipe_id, ingredient_id, unit_id, amount) VALUES (:id, :ingredient, :unit, :amount)');
            $query2->execute(array(
                'id' => $this->id,
                'ingredient' => $ingredients[$i],
                'unit' => $units[$i],
                'amount' => $amounts[$i]
            ));
        }
    }

    public function validate_name_length() {
        return $this->validate_string_length($this->name, 3, 'Reseptin nimi');
    }
        
    public function validate_individual_name() {
        $table = 'Recipe';
        return $this->validate_individual($this->name, $this->id, $table);
    }
            
    public function validate_ingredient_amount() {
        //Tarkistetaan raaka-aineiden määrä vain uusista resepteistä 
        if (is_null($this->id)) {
            return $this->validate_amount($this->ingredients, 1, 'Raaka-aineita');
        } else {
            return $errors = array();
        }
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Recipe SET name = :name, instructions = :instructions 
            WHERE id = :id');
        $query->execute(array(
            'id' => $this->id,
            'name' => $this->name,
            'instructions' => $this->instructions));

        $tags = $this->tags;
        foreach ($tags as $tag) {
            $query = DB::connection()->prepare('INSERT INTO Tagofarecipe (recipe_id, tag_id) VALUES (:id, :tag)');
            $query->execute(array('id' => $this->id, 'tag' => $tag));
        }        
        
        $ingredients = $this->ingredients;
        $amounts = $this->amounts;
        $units = $this->units;
        for ($i = 0; $i < count($units); $i++) {
            $query2 = DB::connection()->prepare('INSERT INTO Ingredientofarecipe (recipe_id, ingredient_id, unit_id, amount) VALUES (:id, :ingredient, :unit, :amount)');
            $query2->execute(array(
                'id' => $this->id,
                'ingredient' => $ingredients[$i],
                'unit' => $units[$i],
                'amount' => $amounts[$i]
            ));
        }
    }

    public function destroy() {
        //Delete from IngredientOfARecipe
        $id = $this->id;
        $query = DB::connection()->prepare('DELETE FROM Ingredientofarecipe WHERE recipe_id = :id');
        $query->execute(array('id' => $id));

        //Delete from TagOfARecipe
        $query2 = DB::connection()->prepare('DELETE FROM Tagofarecipe WHERE recipe_id = :id');
        $query2->execute(array('id' => $id));

        //Delete from FavoriteRecipe
        $query3 = DB::connection()->prepare('DELETE FROM Favoriterecipe WHERE recipe_id = :id');
        $query3->execute(array('id' => $id));

        //Delete from Recipe
        $query4 = DB::connection()->prepare('DELETE FROM Recipe WHERE id = :id');
        $query4->execute(array('id' => $id));
    }

}
