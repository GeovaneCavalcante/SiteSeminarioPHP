<?php
namespace App\Routes\inscricao;

class InscricaoEvento{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }
    
    public function start(){

        $this->klein->respond('GET', '/inscricao', function ($request, $response, $service) {   
                echo $this->twig->getTwig()->render('inscricao\inscricao.html', array(
                    "user" => $_SESSION,
            
                ));  
        });  
        
        $this->klein->respond('POST', '/inscricao', function ($request, $response, $service) {   

            $con = new \App\Controllers\inscricao\InscricaoEvento($_POST);

            if($con->Validacao() or $con->verificar()){
                $endereco = new \App\Controllers\core\Endereco();
                $esp = new \App\Controllers\core\Especialidades();
                echo $this->twig->getTwig()->render('inscricao\inscricao.html', array(
                    "erros" => $con->Validacao(),
                    "verificada" => $con->verificar(),
                    "dados" => $_POST
                ));

            }else{

                if ($con->insertEvento() == 200){
                    $response->redirect('/confirmacao');
                }else{
                    echo "erro";
                }

            }
        });  

        $this->klein->respond('GET', '/admin/inscricoes', function ($request, $response, $service) {
            
            if ($_SESSION['status'] == true){
                $n = new \App\Controllers\inscricao\InscricaoList();
                echo $this->twig->getTwig()->render('/inscricao/list.html', array(
                    "user" => $_SESSION,
                    "inscricoes" => $n->getInscricao()
                ));
            }else{
                $response->redirect('/login');
            }
            
        });

        $this->klein->respond('GET', '/admin/inscricoes/apaga', function ($request, $response, $service) {

            if ($_SESSION['status'] == true){
                if($_GET['dados']){
                    $n = new \App\Controllers\inscricao\InscricaoList();
                    $n->deletaInscricao($_GET['dados']);
                    $response->redirect('/admin/inscricoes');
                }else{
                    $response->redirect('/admin/inscricoes');
                }
            }else{
                $response->redirect('/login');
            }
        });


        $this->klein->respond('GET', '/admin/inscricoes/editar', function ($request, $response, $service) {
            if ($_SESSION['status'] == true){
                if($_GET['dados']){
                    $inscricao = new \App\Models\inscricao\InscricaoEvento();
                    $n = new \App\Controllers\inscricao\InscricaoList();
                    if ($inscricao->getInscricao($_GET['dados']) == 404){
                        echo $this->twig->getTwig()->render('core\error.html');
                    }else{
                       
                        echo $this->twig->getTwig()->render('inscricao\editar.html', array(
                            "user" => $_SESSION,
                            "inscricao" => $inscricao->getInscricao($_GET['dados'])["resultado"]
                        ));
                    }
                }else{
                    $response->redirect('/admin/inscricoes');
                }
            }else{
                $response->redirect('/login');
            }
        });
            
            
        $this->klein->respond('POST', '/admin/inscricoes/editar', function ($request, $response, $service) {
            
            $con = new \App\Controllers\inscricao\InscricaoEvento($_POST);
            if($con->Validacao()){
                echo $this->twig->getTwig()->render('inscricao\editar.html', array(
                    "user" => $_SESSION,
                    "erros" => $con->Validacao(),
                    "inscricao" => $_POST
                ));

            }else{

                if ($con->updateInscricao() == 200){
                    $response->redirect('/admin/inscricoes');
                }else{
                    echo "erro";
                }

            }
            
        });

        $this->klein->respond('GET', '/admin/inscricoes/criar', function ($request, $response, $service) {
            if ($_SESSION['status'] == true){
              
                $inscricao = new \App\Models\inscricao\InscricaoEvento();
                $n = new \App\Controllers\inscricao\InscricaoList();

                echo $this->twig->getTwig()->render('inscricao\criacao.html', array(
                    "user" => $_SESSION,

                ));
            
            
            }else{
                $response->redirect('/login');
            }
        });

        $this->klein->respond('POST', '/admin/inscricoes/criar', function ($request, $response, $service) {
            
            $con = new \App\Controllers\inscricao\InscricaoEvento($_POST);
            if($con->Validacao() or $con->verificar()){
                echo $this->twig->getTwig()->render('inscricao\criacao.html', array(
                    "user" => $_SESSION,
                    "erros" => $con->Validacao(),
                    "inscricao" => $_POST,
                    "exist" => $con->verificar()
                ));

            }else{

                if ($con->insertEventoAdmin() == 200){
                    $response->redirect('/admin/inscricoes');
                }else{
                    echo "erro";
                }

            }
            
        });

        $this->klein->respond('GET', '/confirmacao', function ($request, $response, $service) {   
            echo $this->twig->getTwig()->render('inscricao\confirmacao.html', array(
                "user" => $_SESSION,
        
            ));  
        });  
    }
}