<?php

namespace App\Infra\RepositoriosEmMemoria;

use App\Dominio\Cnpj;
use App\Dominio\Usuario\Loja\Loja;
use App\Dominio\Usuario\Loja\LojaNaoEncontrada;
use App\Dominio\Usuario\Loja\RepositorioDeLoja;

class RepositorioDeLojaEmMemoria implements RepositorioDeLoja
{
    private array $lojas = [];

    public function adicionar(Loja $loja): void
    {
        $this->lojas[] = $loja;
    }

    public function buscarPorCnpj(Cnpj $cnpj): Loja
    {
        $lojasFiltradas = array_filter($this->lojas, function(Loja $loja) use ($cnpj){
            return $loja->getDocumento() == $cnpj;
        });

        if(count($lojasFiltradas) === 0){
            throw new LojaNaoEncontrada($cnpj);
        }

        if(count($lojasFiltradas) > 1){
            throw new \Exception();
        }

        return $lojasFiltradas[0];
    }

    public function buscarTodos(): array
    {
        return $this->lojas;
    }
}