<?php

class IngredientOfARecipe extends BaseModel {
    
    public $recipe_id, $ingredient_id, $unit_id, $amount, $listOrder;
    
        
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
            
}
