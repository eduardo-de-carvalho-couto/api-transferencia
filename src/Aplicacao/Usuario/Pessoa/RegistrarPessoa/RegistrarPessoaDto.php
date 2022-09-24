<?php

namespace App\Aplicacao\Usuario\Pessoa\RegistrarPessoa;

class RegistrarPessoaDto
{
    public string $cpfPessoa;
    public string $nomePessoa;
    public string $emailPessoa;

    public function __construct(string $cpfPessoa, string $nomePessoa, string $emailPessoa)
    {
        $this->cpfPessoa = $cpfPessoa;
        $this->nomePessoa = $nomePessoa;
        $this->emailPessoa = $emailPessoa;
    }
}