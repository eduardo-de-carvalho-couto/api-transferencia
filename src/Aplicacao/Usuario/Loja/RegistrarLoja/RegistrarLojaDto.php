<?php

namespace App\Aplicacao\Usuario\Loja\RegistrarLoja;

class RegistrarLojaDto
{
    public string $cnpjLoja;
    public string $nomeLoja;
    public string $emailLoja;

    public function __construct(string $cnpjLoja, string $nomeLoja, string $emailLoja)
    {
        $this->cnpjLoja = $cnpjLoja;
        $this->nomeLoja = $nomeLoja;
        $this->emailLoja = $emailLoja;
    }
}