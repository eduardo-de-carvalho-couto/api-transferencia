<?php

namespace App\Aplicacao\Usuario\Pessoa\RegistrarPessoa;

use App\Aplicacao\Usuario\UsuarioDto;
use App\Dominio\Usuario\RepositorioInterface;
use App\Dominio\Usuario\Usuario;

class RegistrarUsuario
{
    private RepositorioInterface $repositorio;

    public function __construct(RepositorioInterface $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    public function executa(UsuarioDto $usuarioDto): void
    {
        $usuario = Usuario::comDocumentoNomeEEmail($usuarioDto->documentoUsuario, $usuarioDto->nomeUsuario, $usuarioDto->emailUsuario);
        $this->repositorio->adicionar($usuario);
    }
}