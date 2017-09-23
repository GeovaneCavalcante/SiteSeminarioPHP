<?php

namespace App\Models\account;

class Login{

    private $connect;

    public function __construct(){
        $this->connect = new \Config\Connect();
    }

    public function getRoot($user){

        $sql = "select * from root where username = '$user'";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);

        if($resultado){
            return ["status" => 200, "resultado" => $resultado];
        }else{
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }
    }

}