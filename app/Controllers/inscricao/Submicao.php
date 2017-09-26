<?php
namespace App\Controllers\inscricao;

class Submicao{

    private $post;
    private $InscricaoEvento;
    private $connect;

    public function __construct($post){
        $this->post = $post;
        $this->InscricaoEvento = new \App\Models\inscricao\InscricaoEvento();
        $this->connect = new \Config\Connect();
    }

    public function Validacao(){

        $v = new \Valitron\Validator($this->post);

        $v->rule('required', array(
            'cpf'
        ))->message('{field} é obrigatório');

        if($v->validate()) {
            return $v->errors();
        } else {
            return $v->errors();
        }
    }

    public function ValidacaoSubmicao(){
        
        $v = new \Valitron\Validator($this->post);

        $v->rule('required', array(
            'titulo', 'primeiro_autor', 'conhecimento'
            , 'coordenador', 'orientador'
        ))->message('{field} é obrigatório');

        if($v->validate()) {
            return $v->errors();
        } else {
            return $v->errors();
        }
    }
    
    public function verificarSubmicao($id){

        $model = new \App\Models\inscricao\Submicao();
        $erros = false;
        if($model->getSubmicaoVerificada($id)['status'] == 200){
            $erros = true;
        }

        return $erros;
    
    }

    public function verificar(){

        $erros = [];
          
        $cpf = $this->post['cpf'];
        $sql = "select * from inscricaoevento where cpf = '$cpf'";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);
       
        if ($resultado){
            if($resultado['status_pagamento'] == "sim"){
                $erros['cpf'] = "ok";
                $erros['dados'] = $resultado;
            }else{
                $erros['cpf'] = "not";
                $erros['dados'] = $resultado;
            }
        }else{
            $erros['cpf_exit'] = "Não existe";
        }
        
        return $erros;
       
    }
   
    public function insertSubmicao($dados){
        $model = new \App\Models\inscricao\Submicao();
        if ($model->insertSubmicao($dados)['status'] == 200){
            return 200;
        }
    }

   
}