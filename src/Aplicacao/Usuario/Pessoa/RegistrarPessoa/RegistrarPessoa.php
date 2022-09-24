<?php

namespace App\Aplicacao\Usuario\Pessoa\RegistrarPessoa;

use App\Dominio\Usuario\Pessoa\Pessoa;
use App\Dominio\Usuario\Pessoa\RepositorioDePessoa;

class RegistrarPessoa
{
    private RepositorioDePessoa $repositorioDePessoa;

    public function __construct(RepositorioDePessoa $repositorioDePessoa)
    {
        $this->repositorioDePessoa = $repositorioDePessoa;
    }

    public function executa(RegistrarPessoaDto $pessoaDto): void
    {
        $pessoa = Pessoa::comDocumentoNomeEEmail($pessoaDto->cpfPessoa, $pessoaDto->nomePessoa, $pessoaDto->emailPessoa);
        $this->repositorioDePessoa->adicionar($pessoa);
    }
}