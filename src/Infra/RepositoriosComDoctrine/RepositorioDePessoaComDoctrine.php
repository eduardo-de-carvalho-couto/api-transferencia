<?php

namespace App\Infra\Usuario\RepositoriosComDoctrine;

use App\Dominio\Cpf;
use App\Dominio\Usuario\Pessoa\Pessoa;
use App\Dominio\Usuario\Pessoa\RepositorioDePessoa;
use App\Helper\EntityManagerCreator;

class RepositorioDePessoaComDoctrine implements RepositorioDePessoa
{
    /**
     *  @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = EntityManagerCreator::createEntityManager();
    }

    public function adicionar(Pessoa $pessoa): void
    {
        $this->entityManager->persist($pessoa);
        $this->entityManager->flush();
    }

    public function buscarPorCpf(Cpf $cpf): Pessoa
    {
        //
    }

    public function buscarTodos(): array
    {
        //
    }
}