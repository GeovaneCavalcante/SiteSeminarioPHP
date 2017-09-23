<?php

namespace App\Controllers\account;

class Login{

    private $request;
    private $user;
    private $pass;

    public function __construct($request){

        $this->request = $request;
        $this->user = $request['user'];
        $this->pass = $request['pass'];
    }

    public function validador(){
        
        $root = new \App\Models\account\Login();
        $dados = $root->getRoot($this->user);
        $resultado = $this->verificarUser($dados, $this->user, $this->pass);
        $this->sessao($resultado, $dados);
        return $resultado;
    }

    private function sessao($resultado, $dados){
        
        if (count($resultado)==0){
            $valor = $dados['resultado'];
            $_SESSION['login'] = $valor['username'];
            $_SESSION['senha'] = $valor['pass'];
        }else{
            unset ($_SESSION['login']);
            unset ($_SESSION['senha']);
        }

    }

    private function verificarUser($dados, $user, $pass){

        $error = [];    
        if ($dados['status'] == 200){
            $valor = $dados['resultado'];
            if ($valor['pass'] != $this->pass){
                $error[] = "Senha Incorreta";
            } 
            return $error;
        }else{
            $error[] = "Usuário não existe";
            return $error;
        }
    }
}