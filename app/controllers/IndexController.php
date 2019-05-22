<?php

class IndexController {
    public function index()
    {
        return Helper::view("index");
    }

    /**
     * page quand aucune route n'est trouvée
     * @return view vue 404
     */
    public function routeNotDefined()
    {
        return Helper::view("routeNotDefined");
    }
}
