<?php
namespace App\Routes\medico;

class Medico{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }
    
    public function start(){

        $this->klein->respond('/medicos/cadastro', function ($request, $response, $service) {
            
            if ($_SESSION['status'] == true){
                    $endereco = new \App\Controllers\core\Endereco();
                    $esp = new \App\Controllers\core\Especialidades();
                    echo $this->twig->getTwig()->render('medico\cadastro.html', array(
                    "user" => $_SESSION,
                    "estados" => $endereco->getEstados(),
                    "cidades" => $endereco->getCidades(),
                    "especialidades" => $esp->getEspecialidades()
                ));
            }else{
                $response->redirect('/login');
            }
            
        });


        $this->klein->respond('POST', '/medicos/register', function ($request, $response, $service) {
            $con = new \App\Controllers\medico\Medico($_POST);
            if($con->Validacao() or $con->verificar()){

                $endereco = new \App\Controllers\core\Endereco();
                $esp = new \App\Controllers\core\Especialidades();
                echo $this->twig->getTwig()->render('medico\cadastro.html', array(
                    "user" => $_SESSION,
                    "estados" => $endereco->getEstados(),
                    "cidades" => $endereco->getCidades(),
                    "especialidades" => $esp->getEspecialidades(),
                    "erros" => $con->Validacao(),
                    "exist" => $con->verificar(),
                    "dados" => $_POST
                ));

            }else{

                if ($con->insertMedico() == 200){
                    $response->redirect('/medicos');
                }else{
                    echo "erro";
                }

            }
        });


        $this->klein->respond('GET', '/medicos/editar', function ($request, $response, $service) {

            if ($_SESSION['status'] == true){
                if($_GET['dados']){
                    
                    $medicoList = new \App\Controllers\medico\MedicoList();
                    $endereco = new \App\Controllers\core\Endereco();
                    $esp = new \App\Controllers\core\Especialidades();
                    if ($medicoList->getMedico($_GET['dados']) == 404){
                        echo $this->twig->getTwig()->render('core\error.html');
                    }else{
                        echo $this->twig->getTwig()->render('medico\editar.html', array(
                            "user" => $_SESSION,
                            "dados" => $medicoList->getMedico($_GET['dados']),
                            "estados" => $endereco->getEstados(),
                            "cidades" => $endereco->getCidades(),
                            "especialidades" => $esp->getEspecialidades(),
                            "get" => $_GET['dados']
                        ));
                    }
                }else{
                    $response->redirect('/medicos');
                }
            }else{
                $response->redirect('/login');
            }
        });


        $this->klein->respond('POST', '/medico/editar', function ($request, $response, $service) {
            
            $con = new \App\Controllers\medico\Medico($_POST);
            if($con->verificarUpdate() or $con->Validacao()){

                $endereco = new \App\Controllers\core\Endereco();
                $esp = new \App\Controllers\core\Especialidades();
                echo $this->twig->getTwig()->render('medico\editar.html', array(
                    "user" => $_SESSION,
                    "estados" => $endereco->getEstados(),
                    "cidades" => $endereco->getCidades(),
                    "especialidades" => $esp->getEspecialidades(),
                    "erros" => $con->Validacao(),
                    "exist" => $con->verificarUpdate(),
                    "dados" => $_POST
                ));

            }else{

                if ($con->updateMedico() == 200){
                    $response->redirect('/medicos');
                }else{
                    echo "erro";
                }

            }
          
        });

        $this->klein->respond('GET', '/medicos/apagar', function ($request, $response, $service) {
            
            if ($_SESSION['status'] == true){
                if($_GET['dados']){
                    $medicoList = new \App\Controllers\medico\MedicoList();
                    $medicoList->deletaMedico($_GET['dados']);
                    $response->redirect('/medicos');
                }else{
                    $response->redirect('/medicos');
                }
            }else{
                $response->redirect('/login');
            }
        });

        
        $this->klein->respond('GET', '/medicos', function ($request, $response, $service) {
            
            if ($_SESSION['status'] == true){
                $medicoList = new \App\Controllers\medico\MedicoList();
                echo $this->twig->getTwig()->render('medico\list.html', array(
                    "user" => $_SESSION,
                    "dados" => $medicoList->getMedicos()
                ));
            }else{
                $response->redirect('/login');
            }
          
        });

        
    }
}