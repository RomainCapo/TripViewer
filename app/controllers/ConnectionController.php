<?php

class ConnectionController
{
    public function index()
    {
        return Helper::view("index");
    }

    public function login()
    {
        return Helper::view("login");
    }

    public function register()
    {
        return Helper::view("register");
    }

    public function loginParse()
    {
        if(isset($_POST['username']) && isset($_POST['password']))
        {
            if(User::userPassLinked($_POST['username'], $_POST['password']))
            {
                $user = new User();
                $user->setPseudo($_POST['username']);
                $_SESSION['login'] = serialize($user);

                header('Location: index');
                exit();
            } else { die('user invalid or incorrect password'); }
        }
        else
        {
            header('Location: login');
            exit();
        }
    }

    public function registerParse()
    {
        if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']))
        {
            if($_POST['password'] == $_POST['confirm_password'])
            {
                if(!User::pseudoAlreadyTaken($_POST['username']))
                {
                    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                    {
                        if(User::registerUser($_POST['username'], $_POST['email'], $_POST['password']))
                        {
                            header('Location: login');
                            exit();
                        } else { die('error during register'); }
                    } else { die('invalid email'); }
                } else { die("pseudo already taken"); }
            } else { die('passwords are differents'); }
        }
        else
        {
            header('Location: register');
            exit();
        }
    }

    public function logout()
    {
        session_destroy();
    }
}
