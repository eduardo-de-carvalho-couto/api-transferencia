<?php

namespace App\Testes\Infra;

use App\Infra\CifradorDeSenhaPhp;
use PHPUnit\Framework\TestCase;

class CifradorDeSenhaPhpTest extends TestCase
{
    public function testCifradorDeSenhaPhpDeveCifrarEVerificar()
    {
        $cifrador = new CifradorDeSenhaPhp();
        $senhaCifrada = $cifrador->cifrar('12345678');

        $this->assertSame($cifrador->verificar('12345678', $senhaCifrada), true);
    }
}