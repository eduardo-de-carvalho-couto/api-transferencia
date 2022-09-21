<?php

namespace App\Dominio\Usuario\Loja;

use App\Dominio\Cnpj;

interface RepositorioDeLoja
{
    public function adicionar(Loja $loja): void;
    public function buscarPorCnpj(Cnpj $cnpj): Loja;
    /** @return Loja[] */
    public function buscarTodos(): array;
}