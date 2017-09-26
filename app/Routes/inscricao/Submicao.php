<?php
namespace App\Routes\inscricao;

class Submicao{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }
    
    public function start(){

        $this->klein->respond('GET', '/verificar', function ($request, $response, $service) {   
                echo $this->twig->getTwig()->render('inscricao\verificacao.html', array(
                ));  
        });  

        $this->klein->respond('POST', '/verificar', function ($request, $response, $service) {   
            $v = new \App\Controllers\inscricao\Submicao($_POST);
            if($v->Validacao() or $v->verificar()){
                echo $this->twig->getTwig()->render('inscricao\verificacao.html', array(
                    "errors" => $v->Validacao(),
                    "veri" => $v->verificar(),
                    "dados" => $_POST
                ));  
            }else{
                echo "CERTO";
            }
         
        });  



        $this->klein->respond('GET', '/confirma', function ($request, $response, $service) {   
            
           echo $this->twig->getTwig()->render('inscricao\confirma.html', array(  
            ));     
            
        }); 

        $this->klein->respond('GET', '/error', function ($request, $response, $service) {   
            echo $this->twig->getTwig()->render('inscricao\error.html', array(
            ));  
        });  


        $this->klein->respond('GET', '/submeter', function ($request, $response, $service) {   
            
                $c = new \App\Controllers\inscricao\SubmicaoList();
                if($_GET['id']){
                    if($c->verificar($_GET['id'])['id']== "ok"){
                        echo $this->twig->getTwig()->render('inscricao\submeter.html', array(
                            "get" => $_GET['id']
                        ));  
                    }elseif($c->verificar($_GET['id'])['id']== "not"){
                        $response->redirect('/verificar');
                    }elseif($c->verificar($_GET['id'])['id_exit'] == "not"){
                        $response->redirect('/verificar');
                    }
                }else{
                    $response->redirect('/verificar');
                }
              
        }); 

        $this->klein->respond('POST', '/submeter', function ($request, $response, $service) {   
            
            $v = new \App\Controllers\inscricao\Submicao($_POST);
        
            if ($v->verificarSubmicao($_POST['inscricao'])){
                $response->redirect('/error');
            }elseif($v->ValidacaoSubmicao()){
                echo $this->twig->getTwig()->render('inscricao\submeter.html', array(
                    "erros" => $v->ValidacaoSubmicao(),
                    "veri" => $v->verificar(),
                    "dados" => $_POST
                ));  

            }else{
                $dados = $_POST;
                if($v->insertSubmicao($dados) == 200){
                    $response->redirect('/confirma');
                }else{
                  
                }
            }
              
        }); 
        
        $this->klein->respond('GET', '/admin/trabalhos', function ($request, $response, $service) {   
            
            if ($_SESSION['status'] == true){
                $n = new \App\Controllers\inscricao\SubmicaoList();
                echo $this->twig->getTwig()->render('/inscricao/listTrabalhos.html', array(
                    "user" => $_SESSION,
                    "trabalhos" => $n->getTrabalhos()
                ));
            }else{
                $response->redirect('/login');
            }
        }); 

        
    }
}