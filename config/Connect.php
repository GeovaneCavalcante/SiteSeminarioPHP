<?php 

namespace Config;

class Connect{

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "deep";
    private $conexao;

    public function __construct(){
        $this->conexao = mysqli_connect($this->host, $this->user, $this->pass, $this->db);   
        $this->conexao->set_charset("utf8"); 
    }

    public function testeConnection(){
        if($this->conexao){
            echo "Banco conectado";
        }else{
            echo "Falha ao 'connectar ao bando";
        }
    }
    public function getConnection(){
        return $this->conexao;
    }

}
