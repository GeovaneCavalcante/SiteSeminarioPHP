<?php
namespace App\Controllers\inscricao;

class SubmicaoList{

    private $InscricaoEvento;
    private $connect;
    private $SubmicaoModel;

    public function __construct(){
        $this->InscricaoEvento = new \App\Models\inscricao\InscricaoEvento();
        $this->SubmicaoModel = new \App\Models\inscricao\Submicao();
        $this->connect = new \Config\Connect();
    }
  
    public function verificar($id){
        
        $erros = [];
            
        $sql = "select * from inscricaoevento where id = '$id'";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);
        
        if ($resultado){
            if($resultado['status_pagamento'] == "sim"){
                $erros['id'] = "ok";
                $erros['dados'] = $resultado;
            }else{
                $erros['id'] = "not";
                $erros['dados'] = $resultado;
            }
        }else{
            $erros['id_exit'] = "not";
        }
     
        
        return $erros;
        
    }

    public function getTrabalhos(){
        $trabalhos = $this->SubmicaoModel->getTrabalhos();
        if($trabalhos['status'] == 200){
            return $trabalhos['resultado'];
        }
    }

   
}