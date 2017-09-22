<?php

class TagOfARecipe extends BaseModel {
    
    public $recipe_id, $tag_id;
    
        
    public function __construct($attributes) {
        parent::__construct($attributes);
    }       
}


