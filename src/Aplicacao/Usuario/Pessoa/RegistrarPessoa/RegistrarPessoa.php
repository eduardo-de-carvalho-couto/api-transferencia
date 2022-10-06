<?php

namespace App\Aplicacao\Usuario\Pessoa\RegistrarPessoa;

use App\Dominio\Usuario\CifradorDeSenha;
use App\Dominio\Usuario\Pessoa\Pessoa;
use App\Dominio\Usuario\Pessoa\RepositorioDePessoa;

class RegistrarPessoa
{
    private RepositorioDePessoa $repositorioDePessoa;

    private CifradorDeSenha $cifradorDeSenha;

    public function __construct(RepositorioDePessoa $repositorioDePessoa, CifradorDeSenha $cifradorDeSenha)
    {
        $this->repositorioDePessoa = $repositorioDePessoa;
        $this->cifradorDeSenha = $cifradorDeSenha;
    }

    public function executa(RegistrarPessoaDto $pessoaDto, $senha): void
    {
        $senhaCifrada = $this->cifradorDeSenha->cifrar($senha);
        $pessoa = Pessoa::comDocumentoNomeEEmail($pessoaDto->cpfPessoa, $pessoaDto->nomePessoa, $pessoaDto->emailPessoa, $senhaCifrada);
        $this->repositorioDePessoa->adicionar($pessoa);
    }
}