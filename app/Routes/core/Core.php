<?php

namespace App\Routes\core;


class Core{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }
    
    public function start(){

        $this->klein->respond('/', function ($request, $response, $service) {
            
            echo $this->twig->getTwig()->render('index.html');
                 
            
        });
    }

    public function error(){

        $this->klein->onHttpError(function($code, $router) {
            switch($code) {
                case 404:
                    $router->response()->body(
                        $this->twig->getTwig()->render('/core/error.html', array(
                            "code" => $code
                        ))
                    );
                    break;
                default:
                    $router->response()->body(
                        $this->twig->getTwig()->render('/core/error.html', array(
                            "code" => $code
                        ))
                    );
            }
        });
    }
}