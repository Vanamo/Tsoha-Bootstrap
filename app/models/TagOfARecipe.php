<?php

class TagOfARecipe extends BaseModel {
    
    public $id, $tag_name;
    
        
    public function __construct($attributes) {
        parent::__construct($attributes);
    } 
    
    public static function findTagsOfARecipe($id) {
        $query = DB::connection()->prepare('SELECT Tag.name AS tag_name, Tag.id AS tag_id FROM Tagofarecipe INNER JOIN Tag ON Tagofarecipe.tag_id = Tag.id WHERE recipe_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $tagsOfARecipe = array();

        foreach ($rows as $row) {
            $tagsOfARecipe[] = new TagOfARecipe(array(
                'tag_name' => $row['tag_name'],
                'tag_id' => $row['tag_id']
            ));
        }
        return $tagsOfARecipe;
    }
}


