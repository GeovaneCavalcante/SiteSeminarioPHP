<?php

namespace App\Routes\account;

class Admin{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }
    
    public function start(){

        $this->klein->respond('GET', '/admin', function ($request, $response, $service) {
            
            if ($_SESSION['status'] == true){
                echo $this->twig->getTwig()->render('/account/base.html', array(
                    "user" => $_SESSION,
                ));
            }else{
                $response->redirect('/login');
            }
            
        });
        
    }
}