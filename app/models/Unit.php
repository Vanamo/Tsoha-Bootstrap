<?php

class Unit extends BaseModel {
    
    public $id, $name;
    
        
    public function __construct($attributes) {
        parent::__construct($attributes);
    }       

    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM Unit');
        $query->execute();
        $rows = $query->fetchAll();
        $units = array();

    foreach($rows as $row) {
        $units[] = new Unit(array(
            'id' => $row['id'],
            'name' => $row['name']
        ));
    }

    return $units;
    }
}
