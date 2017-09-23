<?php

namespace App\Routes\account;


class Login{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }
    
    public function start(){

        $this->klein->respond('GET', '/login', function ($request, $response, $service) {
            if ($_SESSION){
                $response->redirect('/admin');
            }else{
                echo $this->twig->getTwig()->render('/account/login.html');
            }
        });

        $this->klein->respond('GET', '/teste', function ($request, $response, $service) {
            if ($_SESSION){
               echo "teste";
            }else{
                echo $this->twig->getTwig()->render('/account/login.html');
            }
         });
 

        $this->klein->respond('POST', '/login', function ($request, $response, $service) {
            
            $n = new \App\Controllers\account\Login($_POST);
            if (count($n->validador()) > 0){
                echo $this->twig->getTwig()->render('/account/login.html', array(
                    "erro" => $n->validador())
                );
            }else{
                $_SESSION['status'] = true;
                $response->redirect('/admin');
            }
        });
        

        $this->klein->respond('GET', '/logout', function ($request, $response, $service) {
            if ($_SESSION){
                session_destroy();
                $response->redirect('/login');
            }else{
                $response->redirect('/');
            }
        });

    }
}