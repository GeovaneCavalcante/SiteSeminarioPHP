<?php
namespace App\Controllers\inscricao;

class InscricaoEvento{

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
            'nome', 'cpf', 'telefone', 'email'
        ))->message('{field} é obrigatório');

        if($v->validate()) {
            return $v->errors();
        } else {
            return $v->errors();
        }
    }
    
    public function verificar(){

        $erros = [];
          
        $cpf = $this->post['cpf'];
        $sql = "select cpf from inscricaoevento where cpf = '$cpf'";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);

        if ($resultado){
            $erros['cpf'] = true;
        }
     
        return $erros;
       
    }

    public function verificarAdmin(){
        
        $erros = [];
            
        $cpf = $this->post['cpf'];
        $sql = "select cpf from inscricaoevento where cpf = '$cpf'";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);

        if ($resultado){
            $erros['cpf'] = true;
        }
        
        $numero_transacao = $this->post['numero_transacao'];
        $sql = "select numero_transacao from inscricaoevento where numero_transacao = '$numero_transacao'";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);
        
        if ($resultado or $resultado["numero_transacao"] != ""){
            $erros['numero_transacao'] = true;
        }
        var_dump($erros);
        die;
        return $erros;
        
    }
   

    public function insertEvento(){
        $result = $this->InscricaoEvento->insertInscricao($this->post);

        if ($result['status'] == 200){
            return 200;
        }else{
            return 405;
        }

    }

    public function insertEventoAdmin(){
        $result = $this->InscricaoEvento->insertInscricaoAdmin($this->post);

        if ($result['status'] == 200){
            return 200;
        }else{
            return 405;
        }

    }

    private function removeMascara($post){

        $post['cpf'] = preg_replace("/\D+/", "", $post['cpf']); 
        $post['telefone'] = preg_replace("/\D+/", "", $post['telefone']);

        return $post;
    
    }

    public function updateInscricao(){

        $result = $this->InscricaoEvento->updateInscricao($this->post);

        if ($result['status'] == 200){
            return 200;
        }else{
            echo "kkk";
            die;
            return 405;
        }
    }

}