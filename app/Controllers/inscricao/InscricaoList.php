<?php

namespace App\Controllers\inscricao;

class InscricaoList{

    private $post;
    private $inscricao;
    private $connect;

    public function __construct(){
        $this->inscricao = new \App\Models\inscricao\InscricaoEvento();
        $this->connect = new \Config\Connect();
    }

    public function getInscricao(){
        $inscricao = $this->inscricao->getInscricoes();

        if ($inscricao['status'] == 200){
            return $inscricao['resultado'];
        }else{
            echo 'ERRO';
        }
    }

    public function getMedico($crm){
        $medicos = $this->modelMedico->getMedico($crm);

        if ($medicos['status'] == 200){
           
            return $medicos['resultado'];
        }else{
          
            return 404;
        }
    }

    public function deletaInscricao($cpf){
        $inscricao = $this->inscricao->deletaInscricao($cpf);

        if ($inscricao['status'] == 200){
            echo "apagado";
        }else{
            echo 'ERRO';
        }
    }
}