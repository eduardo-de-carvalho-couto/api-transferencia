<?php

namespace App\Dominio\Usuario\Pessoa;

use App\Dominio\Cpf;

class PessoaNaoEncontrada extends \DomainException
{
    public function __construct(Cpf $cpf)
    {
        parent::__construct("Usuario com CPF $cpf não encontrado");
    }
}