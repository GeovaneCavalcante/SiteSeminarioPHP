<?php

namespace App\Routes;

class Twig {

    private $twig;

    public function __construct() {
        $template =  __DIR__ . '/../Views';
        $loader = new \Twig_Loader_Filesystem($template);
        $this->twig = new \Twig_Environment($loader);
    }

    public function getTwig() {
        return $this->twig;
    }
}