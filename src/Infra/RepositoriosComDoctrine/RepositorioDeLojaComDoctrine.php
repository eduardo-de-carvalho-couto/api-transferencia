<?php

namespace App\Infra\RepositoriosComDoctrine;

use App\Dominio\Cnpj;
use App\Dominio\Usuario\Loja\Loja;
use App\Dominio\Usuario\Loja\RepositorioDeLoja;

class RepositorioDeLojaComDoctrine implements RepositorioDeLoja
{
    public function adicionar(Loja $loja): void
    {
        //
    }

    public function buscarPorCnpj(Cnpj $cnpj): Loja
    {
        //
    }

    public function buscarTodos(): array
    {
        //
    }
}