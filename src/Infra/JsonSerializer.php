<?php

namespace App\Infra;

use App\Dominio\Usuario\Usuario;

class JsonSerializer implements \JsonSerializable
{
    private ?Usuario $usuario;

    public function __construct(?Usuario $usuario)
    {
        $this->usuario = $usuario;
    }
    
    public function jsonSerialize()
    {
        if($this->usuario == null){
            return;
        }

        return [
            'id' => $this->usuario->getId(),
            'documento' => $this->usuario->getDocumento(),
            'nome' => $this->usuario->getNome(),
            'email' => $this->usuario->getEmail()
        ];
    }
}