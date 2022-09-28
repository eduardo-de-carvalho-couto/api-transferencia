<?php

namespace App\Aplicacao\Usuario;

class UsuarioDto
{
    public string $documentoUsuario;
    public string $nomeUsuario;
    public string $emailUsuario;

    public function __construct(string $documentoUsuario, string $nomeUsuario, string $emailUsuario)
    {
        $this->documentoUsuario = $documentoUsuario;
        $this->nomeUsuario = $nomeUsuario;
        $this->emailUsuario = $emailUsuario;
    }
}