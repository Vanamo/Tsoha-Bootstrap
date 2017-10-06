<?php

class IngredientOfARecipe extends BaseModel {

    public $id, $amount, $ingredient_name, $unit_name, $listOrder;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findIngredientsOfARecipe($id) {
        $query = DB::connection()->prepare('SELECT Ingredientofarecipe.id AS id_i, Ingredientofarecipe.amount, Ingredient.name AS ingredient_name, Unit.name AS unit_name, Ingredientofarecipe.listorder FROM Ingredientofarecipe INNER JOIN Unit ON Unit.id = Ingredientofarecipe.unit_id INNER JOIN Ingredient ON Ingredient.id = Ingredientofarecipe.ingredient_id WHERE recipe_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $ingredientsOfARecipe = array();

        foreach ($rows as $row) {
            $ingredientsOfARecipe[] = new IngredientOfARecipe(array(
                'id' => $row['id_i'],
                'amount' => $row['amount'],
                'ingredient_name' => $row['ingredient_name'],
                'unit_name' => $row['unit_name'],
                'listorder' => $row['listorder']
            ));
        }
        return $ingredientsOfARecipe;
    }

    public function destroy() {
        $id = $this->id;
        $query = DB::connection()->prepare('DELETE FROM Ingredientofarecipe WHERE id = :id');
        $query->execute(array('id' => $id));
    }

}
