<?php

namespace App\Testes\Dominio\Pessoa;

use App\Dominio\Usuario\Pessoa\Pessoa;
use PHPUnit\Framework\TestCase;

class PessoaTest extends TestCase
{
    public function testPessoaDeveSerCriadaComDocumentoNomeEEmailValido()
    {
        $pessoa = Pessoa::comDocumentoNomeEEmail(
            '123.456.789-10',
            'Teste',
            'teste@teste.com',
            '12345678'
        );
        
        $this->assertSame('123.456.789-10', $pessoa->getDocumento());
        $this->assertSame('Teste', $pessoa->getNome());
        $this->assertSame('teste@teste.com', $pessoa->getEmail());
    }

    public function testPessoaDevePoderAtualizarOEmail()
    {
        $pessoa = Pessoa::comDocumentoNomeEEmail(
            '123.456.789-10',
            'Edu',
            'edu@teste.com',
            '12345678'
        );

        $pessoa->setEmail('novo@endereco.com');

        $this->assertSame('novo@endereco.com', $pessoa->getEmail());
    }

    public function testPessoaDevePoderAtualizarOCpf()
    {
        $pessoa = Pessoa::comDocumentoNomeEEmail(
            '213.564.879-12',
            'Edu',
            'edu@teste.com',
            '12345678'
        );

        $pessoa->setDocumento('123.456.789-10');
        
        $this->assertSame('123.456.789-10', $pessoa->getDocumento());
    }
}