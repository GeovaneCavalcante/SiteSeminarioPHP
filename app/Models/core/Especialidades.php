<?php
namespace App\Models\core;

class Especialidades{

    private $connect;

    public function __construct(){
        $this->connect = new \Config\Connect();
    }

    public function getEspecialidades(){
        $sql = 'SELECT * FROM especialidades';
        $result = $this->connect->getConnection()->query($sql);
        if ($result){
            $i = 0;
            $array = [];
            while ($dados = mysqli_fetch_assoc($result)){
                $array[$i] = $dados;
                $i++;
            }
            return ["status" => 200, "resultado" => $array];
        }else{

            return ["status" => 404, "resultado" => "Nada encontrado"];
        }
    }

    public function getEspecialidade($nome){

        $sql = "select * from especialidades where nome = '$nome'";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);

        return $resultado;
    }

    public function updateEspecialidadeCRM(){
        
        $sql = "
            UPDATE `mydb`.`especialidades_med` SET 
            `crm_medico`= 12
            WHERE `crm_medico`= '455445'"
        ;
      
        if($this->connect->getConnection()->query($sql)==true){
            echo "Atualizado com sucesso" . $this->connect->getConnection()->error;
            return ["status" => 200, "resultado" => "Atualizado com sucesso"];
        }else{
            
            $error = $this->connect->getConnection()->error;
            echo "Falha ao criar registro" . $error;
            return ["status" => 405, "resultado" => "Falha ao atualizar registro:  $error "];
        }        
    }

    public function destroiEspecialidades($crm){

         $sql = "delete from especialidades_med where crm_medico = $crm";
         
        if($this->connect->getConnection()->query($sql)==true){
            return ["status" => 200, "resultado" => "apagado com sucesso"];
        }else{
            $error = $this->connect->getConnection()->error;
            return ["status" => 405, "resultado" => "Falha ao apagar registro:  $error "];
        }        

    }
}