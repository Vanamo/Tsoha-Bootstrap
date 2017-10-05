<?php

class UserController extends BaseController {

    public static function index() {
        //Haetaan kaikki reseptit tietokannasta
        //Tässä pitäisi hakea vain kymmenen suosituinta reseptiä
        $recipes = Recipe::all();
        View::make('user/home.html', array('recipes' => $recipes));
    }

    public static function login() {
        View::make('user/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $user = User::authenticate($params['username'], $params['password']);

        if (!$user) {
            View::make('/user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!',
                'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;

            Redirect::to('/user/' . $user->id . '/loginHome', array('message' => 'Tervetuloa ' . $user->name . '!'));
        }
    }

    public static function showLoginHome($id) {
        $user = User::find($id);
        $userRecipes = User::findUserRecipes($id);
        $favoriteRecipes = FavoriteRecipe::find($id);
        View::make('/user/loginHome.html', array('user' => $user,
            'userRecipes' => $userRecipes,
            'favoriteRecipes' => $favoriteRecipes));
    }

    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/', array('message' => 'Olet kirjautunut ulos'));
    }
   
    public static function storeFavorite($id) {
        $user = self::get_user_logged_in();
        $attributes = array(
            'recipe_id' => $id,
            'customer_id' => $user->id
        );
        
        $favoriteRecipe = new FavoriteRecipe($attributes);
        $favoriteRecipe->saveFavorite();
        Redirect::to('/recipe/' . $id, array('message' => 'Resepti on tallennettu suosikkeihin'));
    }
    
    public static function destroyFavorite($id) {
        $user = self::get_user_logged_in();
        $favoriteRecipe = new FavoriteRecipe(array('recipe_id' => $id, 'customer_id' => $user->id));
        $favoriteRecipe->destroy();

        Redirect::to('/user/' . $user->id . '/loginHome', array('message' => 'Resepti on poistettu suosikeista'));
        
    }
}
