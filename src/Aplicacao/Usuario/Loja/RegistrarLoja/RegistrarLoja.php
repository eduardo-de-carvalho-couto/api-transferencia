<?php

namespace App\Aplicacao\Usuario\Loja\RegistrarLoja;

use App\Dominio\Usuario\CifradorDeSenha;
use App\Dominio\Usuario\Loja\Loja;
use App\Dominio\Usuario\Loja\RepositorioDeLoja;

class RegistrarLoja
{
    private RepositorioDeLoja $repositorioDeLoja;

    private CifradorDeSenha $cifradorDeSenha;

    public function __construct(RepositorioDeLoja $repositorioDeLoja, CifradorDeSenha $cifradorDeSenha)
    {
        $this->repositorioDeLoja = $repositorioDeLoja;
        $this->cifradorDeSenha = $cifradorDeSenha;
    }

    public function executa(RegistrarLojaDto $lojaDto, $senha)
    {
        $senhaCifrada = $this->cifradorDeSenha->cifrar($senha);
        $loja = Loja::comDocumentoNomeEEmail($lojaDto->cnpjLoja, $lojaDto->nomeLoja, $lojaDto->emailLoja, $senhaCifrada);
        $this->repositorioDeLoja->adicionar($loja);
    }
}