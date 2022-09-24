<?php

namespace App\Aplicacao\Usuario\Loja\RegistrarLoja;

use App\Dominio\Usuario\Loja\Loja;
use App\Dominio\Usuario\Loja\RepositorioDeLoja;

class RegistrarLoja
{
    private RepositorioDeLoja $repositorioDeLoja;

    public function __construct(RepositorioDeLoja $repositorioDeLoja)
    {
        $this->repositorioDeLoja = $repositorioDeLoja;
    }

    public function executa(RegistrarLojaDto $lojaDto)
    {
        $loja = Loja::comDocumentoNomeEEmail($lojaDto->cnpjLoja, $lojaDto->nomeLoja, $lojaDto->emailLoja);
        $this->repositorioDeLoja->adicionar($loja);
    }
}