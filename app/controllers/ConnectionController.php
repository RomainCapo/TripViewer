<?php

require '/models/User.php';

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
      echo "loginParse";
    }

    public function registerParse()
    {
        if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']))
        {
            if(User::pseudoAlreadyTaken($_POST['username']))
            {

            }
        }
        else
        {
            header('Location : register');
            exit();
        }
    }
}
