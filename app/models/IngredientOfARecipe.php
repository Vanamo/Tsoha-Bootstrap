<?php

class IngredientOfARecipe extends BaseModel {
    
    public $amount, $ingredient_name, $unit_name, $listOrder;
    
        
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
            
}
