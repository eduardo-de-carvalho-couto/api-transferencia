<?php

namespace App\Dominio\Usuario\Pessoa;

use App\Dominio\Cpf;

interface RepositorioDePessoa
{
    public function adicionar(Pessoa $pessoa): void;
    public function buscarPorCpf(Cpf $cpf): Pessoa;
    /** @return Pessoa[] */
    public function buscarTodos(): array;
}