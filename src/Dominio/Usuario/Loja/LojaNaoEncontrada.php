<?php

namespace App\Dominio\Usuario\Loja;

use App\Dominio\Cnpj;

class LojaNaoEncontrada extends \DomainException
{
    public function __construct(Cnpj $cnpj)
    {
        parent::__construct("Loja com CNPJ $cnpj não encontrada.");
    }
}