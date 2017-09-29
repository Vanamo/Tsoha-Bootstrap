<?php

class UserController extends BaseController{

    public static function index(){
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
        
        //VIESTIT EIVÄT NÄY
        if(!$user) {
            View::make('/user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!',
                'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;
            
            Redirect::to('/user/' . $user->id . '/loginHome', array('message' => 'Tervetuloa ' . $user->name . '!'));
        }
    }
    
    public static function showLoginHome($id) {
        $user = User::find($id);
        $userRecipes = Recipe::findUserRecipes($id);
        $favoriteRecipes = Recipe::findFavoriteRecipes($id); 
        View::make('/user/loginHome.html', array('user' => $user, 
            'userRecipes' => $userRecipes, 
            'favoriteRecipes' => $favoriteRecipes));
    }
}
