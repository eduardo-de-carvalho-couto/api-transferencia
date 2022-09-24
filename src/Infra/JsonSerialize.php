<?php

namespace App\Infra;

use App\Dominio\Usuario\Usuario;

class JsonSerialize implements \JsonSerializable
{
    private Usuario $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }
    
    public function jsonSerialize()
    {
        return [
            'id' => $this->usuario->getId(),
            'documento' => $this->usuario->getDocumento(),
            'nome' => $this->usuario->getNome(),
            'email' => $this->usuario->getEmail()
        ];
    }
}