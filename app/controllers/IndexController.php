<?php

class IndexController {
    public function index()
    {
        return Helper::view("index");
    }

    public function routeNotDefined()
    {
        return Helper::view("routeNotDefined");
    }
}