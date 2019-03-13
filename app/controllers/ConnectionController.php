<?php

class ConnectionController
{
    private $error_login = [];
    private $error_register = [];

    private $isProcessingError_login = false;
    private $isProcessingError_register = false;

    public function index()
    {
        return Helper::view("index");
    }

    public function login()
    {
        return Helper::view("login", ['error_login' => $this->error_login]);
    }

    public function register()
    {
        return Helper::view("register", ['error_register' => $this->error_register]);
    }

    public function loginParse()
    {
        if(isset($_POST['username']) && isset($_POST['password']))
        {
            if(User::userPassLinked($_POST['username'], $_POST['password']))
            {
                $user = new User();
                $user->setPseudo($_POST['username']);
                $id = $user->getIdByPseudo($_POST['username']);
                $user->setId($id);
                $_SESSION['login'] = serialize($user);

                header('Location: index');
                exit(0);
            } 
            else 
            { 
                $isProcessingError_login = true;
                $this->error_login['user'] = "User invalid or incorrect password"; 
            }
        }
        else
        {
            header('Location: login');
            exit(0);
        }

        if($isProcessingError_login)
        {
            return $this->login();
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
                            exit(0);
                        } 
                        else 
                        {
                            $isProcessingError_register = true;
                            $this->error_register['register'] = "Error during registration";
                        }
                    } 
                    else 
                    { 
                        $isProcessingError_register = true;
                        $this->error_register['email'] = "Invalid email"; 
                    }
                } 
                else 
                { 
                    $isProcessingError_register = true;
                    $this->error_register['pseudo'] = "Pseudo already taken";
                }
            } 
            else 
            { 
                $isProcessingError_register = true;
                $this->error_register['password'] = "Passwords are differents"; 
            }
        }
        else
        {
            header('Location: register');
            exit(0);
        }

        if($isProcessingError_register)
        {
            return $this->register();
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: login');
        exit(0);
    }

    public function test()
    {
        $a;

        $a['test'] = '123';
        $a['okok'] = 'zip';
        
        
        //var_dump($a);
        echo $a['test'];
    }
}
