<?php

namespace App\Dominio\Usuario\Pessoa;

use App\Dominio\Cpf;
use App\Dominio\Email;
use App\Dominio\Usuario\Usuario;

class Pessoa extends Usuario
{
    private Cpf $cpf;

    public static function comDocumentoNomeEEmail(string $documento, string $nome, string $email): self 
    {
        return new Pessoa(new Cpf($documento), $nome, new Email($email));
    }

    public function __construct(Cpf $cpf, string $nome, Email $email)
    {
        parent::__construct($nome, $email);
        
        $this->cpf = $cpf;
    }

    public function getDocumento(): string
    {
        return $this->cpf;
    }
}