<?php

namespace App\Controllers\core;

class Especialidades{

    private $especialidades;

    public function __construct(){
        $especialidades = new \App\Models\core\Especialidades();
        $this->especialidades = $especialidades->getEspecialidades();
    }

    public function getEspecialidades(){
        if($this->especialidades['status'] == 200){
            return $this->especialidades['resultado'];
        }else{
            return "Erro 404 nada encontrado"; 
        }
    }
}