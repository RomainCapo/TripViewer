<?php

class ConnectionController
{
    public function index()
    {
        return Helper::view("login");
    }

    public function parseLogin()
    {
      echo "parseLogin";
    }
}
