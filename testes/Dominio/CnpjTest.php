<?php

namespace App\Testes\Dominio;

use App\Dominio\Cnpj;
use PHPUnit\Framework\TestCase;

class CnpjTest extends TestCase
{
    public function testCnpjComNumeroNoFormatoInvalidoNaoDevePoderExistir()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Cnpj('123.456.789-10');
    }

    public function testCnpjDevePoderSerRepresentadoComoString()
    {
        $cpf = new Cnpj('12.345.678/0001-12');
        $this->assertSame('12.345.678/0001-12', (string) $cpf);
    }
}