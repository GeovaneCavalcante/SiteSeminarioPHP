<?php 

require_once __DIR__ . "/../../config/Connect.php";

class Contato{

    protected $conexao;

    function __construct(){
        $this->conexao = new Connect();
    }

    function getContatos(){
       $sql = "SELECT * FROM contatos";
       $result = $this->conexao->getConnection()->query($sql);
       if (!$result){
           return ["status" => 404, "resultado" => "Nada encontrado"];
       }else{
           $i = 0;
           while ($dados = mysqli_fetch_assoc($result)){
                $array[$i] = $dados;
                $i++;
           }
           return ["status" => 200, "resultado" => $array];
       }
    }

    function insertContato($dados){
        $sql = "
            INSERT INTO contatos (nome, email, celular)
            VALUES ('$dados[nome]', '$dados[email]', '$dados[celular]')
        ";
        if ($this->conexao->getConnection()->query($sql) == true){
            echo "Criado com sucesso";
            return ["status" => 200, "resultado" => "Criado com sucesso"];;
        }else{
            echo "Falha ao criar registro";
            $error = $this->conexao->getConnection()->error;
            return ["status" => 405, "resultado" => "Falha ao criar registro: $error"];;
        }
    }

    function updateContato($dados){
        $sql = "
            UPDATE contatos 
            SET nome = '$dados[nome]', email = '$dados[email]', celular = '$dados[celular]'
            WHERE id = '$dados[id]'
        ";

        if($this->conexao->getConnection()->query($sql)==true){
            echo "Atualizado com sucesso";
            return ["status" => 200, "resultado" => "Atualizado com sucesso"];
        }else{
            echo "Falha ao criar registro";
            $error = $this->conexao->getConnection()->error;
            return ["status" => 405, "resultado" => "Falha ao atualizar registro:  $error "];
        }        
    }

    function deleteContato($dados){
        $sql = "
            DELETE FROM contatos
            WHERE id='$dados[id]'
        ";
        if ($this->conexao->getConnection()->query($sql) == true){
            echo "Resgistro apado";
            return ["status" => 200, "resultado" => "Apagado com sucesso"];
        }else{
            echo "Erro ao apagar registro";
            $error = $this->conexao->getConnection()->error;
            return ["status" => 405, "resultado" => "Resgistro não apagado: $error"];
        }
    }

}

$co = new Contato();
/*
$resultado = $co->getContatos()['resultado'];
foreach ($resultado as $val){
    echo $val['nome'] . '<br>';
}
/*
$co->insertContato([
    "nome" => "pedrassasaasassasasasao",
    "email" => "teste@gmail.com",
    "celular" => "9998409741"
]);
*/
/*


$co->updateContato([
    "nome" => "psassas",
    "email" => "teste@gmail.com",
    "celular" => "9998409741",
    "id" => 3
]);

/*
$co->deleteContato(["id" => 1,]);
*/