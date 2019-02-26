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
      echo "loginParse";
    }

    public function registerParse()
    {
      echo "registerParse";
    }
}
