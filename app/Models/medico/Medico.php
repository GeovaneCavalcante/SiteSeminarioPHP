<?php 

namespace App\Models\medico;

class Medico{

    private $connect;

    public function __construct(){
        $this->connect = new \Config\Connect();
    } 

    public function insertMedico($dados){
    
        $sql = "
            INSERT INTO medicos 
            (crm, nome, endereco, bairro,
            cidade, estado, cep, complemento, cpf, rg,
            data_nascimento, naturalidade, nacionalidade,
            email, telefone, celular, trabalho)
            VALUES 
            ('$dados[crm]', '$dados[nome]', '$dados[endereco]', '$dados[endereco]',
            '$dados[cidade]', '$dados[estado]', '$dados[cep]', '$dados[complemento]',
            '$dados[cpf]', '$dados[rg]', '$dados[data_nascimento]', '$dados[naturalidade]',
            '$dados[nacionalidade]', '$dados[email]', '$dados[telefone]', '$dados[celular]',
            '$dados[trabalho]'
            )
        ";
        
        if ($this->connect->getConnection()->query($sql) == true){
            $this->insertEspecialidades($dados);
            echo "Criado com sucesso";
            return ["status" => 200, "resultado" => "Criado com sucesso"];;
        }else{
            echo "Falha ao criar registro " . mysqli_error($this->connect->getConnection()); 
            $error = $this->connect->getConnection()->error;
            return ["status" => 405, "resultado" => "Falha ao criar registro: $error"];;
        }
    }

    public function insertEspecialidades($dados){
        
        if ($dados['especialidades']){
            foreach ($dados['especialidades'] as $value){
                $medico = new \App\Models\core\Especialidades();
            
                $especialidade = $medico->getEspecialidade($value);
                $sql = "
                    INSERT INTO especialidades_med 
                    (nome, crm_medico, id_especialidades)
                    VALUES 
                    ('$value', '$dados[crm]', '$especialidade[id]')
                ";
                $this->connect->getConnection()->query($sql);
            }
        }

    }

    public function updateEspecialidades($dados){
        
        if ($dados['especialidades']){
            $medico = new \App\Models\core\Especialidades();
            $medico->destroiEspecialidades($dados['crm']);
            foreach ($dados['especialidades'] as $value){ 
            
                $especialidade = $medico->getEspecialidade($value);
                $sql = "
                    INSERT INTO especialidades_med 
                    (nome, crm_medico, id_especialidades)
                    VALUES 
                    ('$value', '$dados[crm]', '$especialidade[id]')
                ";
                $this->connect->getConnection()->query($sql);
            }
        }

    }


    public function getMedicos(){
        
        $sql = "SELECT * FROM medicos order by nome asc
        ";
        $result = $this->connect->getConnection()->query($sql);

        if (!$result){
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }else{
            $i = 0;
            while ($dados = mysqli_fetch_assoc($result)){

                $sql2 = "SELECT * FROM especialidades_med WHERE crm_medico = '$dados[crm]'";
                $result2 = $this->connect->getConnection()->query($sql2);
                $j = 0;
                $array2 = [];
                while ($dados2 = mysqli_fetch_assoc($result2)){
                    $array2[$j] = $dados2;
                    $j++;
                }
                $dados['especialidades'] = $array2;
                $array[$i] = $dados;
                $i++;
            }
            return ["status" => 200, "resultado" => $array];
        }
    }


    public function getMedico($crm){
        
        $sql = "select * from medicos where crm = $crm";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);

        if($resultado){
            
            $sql2 = "SELECT * FROM especialidades_med WHERE crm_medico = '$resultado[crm]'";
            $result2 = $this->connect->getConnection()->query($sql2);
            $j = 0;
            $array2 = [];
            while ($dados2 = mysqli_fetch_assoc($result2)){
                $array2[$j] = $dados2;
                $j++;
            }

            if($array2){
               $resultado['esp'] =  $array2;
            }else{
               $resultado['esp'] = "Nada encontrado";
            }

            return ["status" => 200, "resultado" => $resultado];
        }else{
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }
    }


    public function updateMedico($dados){
      
        $sql = "
        UPDATE `mydb`.`medicos` SET 
        `crm`='$dados[crm]', `nome`='$dados[nome]', `endereco`='$dados[endereco]',
        `bairro`='$dados[bairro]', `cidade`='$dados[cidade]', `estado`='$dados[estado]', 
        `cep`='$dados[cep]', `complemento`='$dados[complemento]', `cpf`='$dados[cpf]', `rg`='$dados[rg]', 
        `data_nascimento`='$dados[data_nascimento]', `naturalidade`='$dados[naturalidade]', 
        `nacionalidade`='$dados[nacionalidade]',
         `email`='$dados[email]', `telefone`= '$dados[telefone]', 
         `celular`= '$dados[celular]', `trabalho`= '$dados[trabalho]' WHERE `crm`= '$dados[get]';
        
        ";
      
        if($this->connect->getConnection()->query($sql)==true){
            echo "Atualizado com sucesso" . $this->connect->getConnection()->error;
            return ["status" => 200, "resultado" => "Atualizado com sucesso"];
        }else{
            
            $error = $this->connect->getConnection()->error;
            echo "Falha ao criar registro" . $error;
            return ["status" => 405, "resultado" => "Falha ao atualizar registro:  $error "];
        }        
    }

    function deletaMedico($crm){
        $sql = "
            DELETE FROM medicos
            WHERE crm='$crm'
        ";
        if ($this->connect->getConnection()->query($sql) == true){
            echo "Resgistro apado";
            return ["status" => 200, "resultado" => "Apagado com sucesso"];
        }else{
            echo "Erro ao apagar registro";
            $error = $this->connect->getConnection()->error;
            return ["status" => 405, "resultado" => "Resgistro não apagado: $error"];
        }
    }

}