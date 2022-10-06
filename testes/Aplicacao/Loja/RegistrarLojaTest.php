<?php

namespace App\Testes\Aplicacao\Pessoa;

use App\Aplicacao\Usuario\Loja\RegistrarLoja\RegistrarLoja;
use App\Aplicacao\Usuario\Loja\RegistrarLoja\RegistrarLojaDto;
use App\Dominio\Cnpj;
use App\Infra\CifradorDeSenhaPhp;
use App\Infra\RepositoriosEmMemoria\RepositorioDeLojaEmMemoria;
use PHPUnit\Framework\TestCase;

class RegistrarLojaTest extends TestCase
{
    public function testLojaDeveSerAdicionadaAoRepositorio()
    {
        $dadosLoja = new RegistrarLojaDto(
            '12.345.678/0001-12',
            'Loja Teste',
            'loja@exemplo.com'
        );

        $repositorioDeLoja = new RepositorioDeLojaEmMemoria();
        $cifradorDeSenha = new CifradorDeSenhaPhp();

        $useCase = new RegistrarLoja($repositorioDeLoja, $cifradorDeSenha);

        $useCase->executa($dadosLoja, '12345678');

        $loja = $repositorioDeLoja->buscarPorCnpj(new Cnpj('12.345.678/0001-12'));
        $this->assertSame('Loja Teste', (string) $loja->getNome());
        $this->assertSame('loja@exemplo.com', (string) $loja->getEmail());
    }
}