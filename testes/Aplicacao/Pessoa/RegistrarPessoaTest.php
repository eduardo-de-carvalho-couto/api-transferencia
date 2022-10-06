<?php

namespace App\Testes\Aplicacao\Pessoa;

use App\Infra\RepositoriosEmMemoria\RepositorioDePessoaEmMemoria;
use App\Aplicacao\Usuario\Pessoa\RegistrarPessoa\RegistrarPessoaDto;
use App\Aplicacao\Usuario\Pessoa\RegistrarPessoa\RegistrarPessoa;
use App\Dominio\Cpf;
use App\Infra\CifradorDeSenhaPhp;
use PHPUnit\Framework\TestCase;

class RegistrarPessoaTest extends TestCase
{
    public function testPessoaDeveSerAdicionadaAoRepositorio()
    {
        $dadosPessoa = new RegistrarPessoaDto(
            '123.456.789-10', 
            'Eduardo', 
            'eduardo@teste.com'
        );

        $repositorioDePessoa = new RepositorioDePessoaEmMemoria();
        $cifradorDeSenha = new CifradorDeSenhaPhp();

        $useCase = new RegistrarPessoa($repositorioDePessoa, $cifradorDeSenha);

        $useCase->executa($dadosPessoa, '12345678');

        $pessoa = $repositorioDePessoa->buscarPorCpf(new Cpf('123.456.789-10'));
        $this->assertSame('Eduardo', (string) $pessoa->getNome());
        $this->assertSame('eduardo@teste.com', (string) $pessoa->getEmail());
    }
}