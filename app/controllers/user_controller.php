<?php

class UserController extends BaseController{
    
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
            
            Redirect::to('/user/loginHome', array('message' => 'Tervetuloa' . $user->name . '!'));
        }
    }
    
    public static function showLoginHome() {
        View::make('/user/loginHome.html');
    }
}
