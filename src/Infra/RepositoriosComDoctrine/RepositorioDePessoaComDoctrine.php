<?php

namespace App\Infra\Usuario\RepositoriosComDoctrine;

use App\Aplicacao\Usuario\Pessoa\RegistrarPessoa\RegistrarPessoaDto;
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

    public function buscarPorId(int $id): ?Pessoa
    {
        $registro = $this->entityManager->getRepository(Pessoa::class);
        $pessoa = $registro->find($id);

        return $pessoa;
    }

    public function buscarTodos(): array
    {
        $registro = $this->entityManager->getRepository(Pessoa::class);
        $pessoasLista = $registro->findAll();
        
        return $pessoasLista;
    }

    public function atualizar(int $id, RegistrarPessoaDto $pessoaDto): ?Pessoa
    {
        $pessoaExistente = $this->buscarPorId($id);
        if(is_null($pessoaExistente)){
            return $pessoaExistente;
        }

        $pessoaAtualizada = $pessoaExistente
            ->setDocumento($pessoaDto->cpfPessoa)
            ->setNome($pessoaDto->nomePessoa)
            ->setEmail($pessoaDto->emailPessoa);
        
        $this->entityManager->flush();
        
        return $pessoaAtualizada;
    }

    public function remove(int $id): void
    {
        $pessoa = $this->buscarPorId($id);
        $this->entityManager->remove($pessoa);
        $this->entityManager->flush();
    }
}