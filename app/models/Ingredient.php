<?php

class Ingredient extends BaseModel {
    
    public $id, $name;
    
        
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Ingredient WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row) {
            $ingredient = new Ingredient(array(
                'id' => $row['id'],
                'name' => $row['name']             
            ));
        }
        return $ingredient;
    }     
    

    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM Ingredient');
        $query->execute();
        $rows = $query->fetchAll();
        $ingredients = array();

    foreach($rows as $row) {
        $ingredients[] = new Ingredient(array(
            'id' => $row['id'],
            'name' => $row['name']
        ));
    }

    return $ingredients;
    }
}
