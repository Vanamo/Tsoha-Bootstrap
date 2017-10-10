<?php

class UserController extends BaseController {

    public static function index() {
//Haetaan kaikki reseptit tietokannasta
        $recipes = Recipe::all();
        View::make('user/home.html', array('recipes' => $recipes));
    }

    public static function login() {
        View::make('user/login.html');
    }

    public static function signUp() {
        View::make('user/signUp.html');
    }

    public static function handle_signUp() {
        $params = $_POST;

        if ($params['password'] != $params['password_check']) {
            View::make('/user/signUp.html', array('message' => 'Salasanat eivät täsmää!',
                'username' => $params['username']));
        }
        $attributes = array(
            'name' => $params['username'],
            'password_hash' => $params['password']
        );

        $user = New User($attributes);
        $errors = $user->errors();

        if (count($errors) == 0) {
            $user->save();
            $_SESSION['user'] = $user->id;
            Redirect::to('/user/' . $user->id . '/loginHome', array('message' => 'Tervetuloa ' . $user->name . '!'));
        } else {
            View::make('/user/signUp.html', array('errors' => $errors));
        }
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

    public static function changePassword($id) {
        View::make('/user/changePassword.html');
    }
    
    public static function updatePassword($id) {
        $params = $_POST;
        $old_user = self::get_user_logged_in();

        if ($params['password'] != $params['password_check']) {
            View::make('/user/changePassword.html', array('message' => 'Salasanat eivät täsmää!'));
        }

        $attributes = array(
            'id' => $id,
            'name' => $old_user->name,
            'password_hash' => $params['password']
        );

        $user = new User($attributes);

        $user->update_password();
        $errors = $user->errors();
        
        if (count($errors) > 0) {
            View::make('/user/changePassword.html', array('errors' => $errors));
        }

        Redirect::to('/user/' . $user->id . '/loginHome', array('message' => 'Salasana on vaihdettu onnistuneesti'));
    }

}
