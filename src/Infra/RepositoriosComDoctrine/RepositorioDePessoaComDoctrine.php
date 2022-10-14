<?php

namespace App\Infra\RepositoriosComDoctrine;

use App\Aplicacao\Usuario\UsuarioDto;
use App\Dominio\Cpf;
use App\Dominio\Usuario\Pessoa\Pessoa;
use App\Dominio\Usuario\Pessoa\RepositorioDePessoa;
use App\Dominio\Usuario\RepositorioInterface;
use App\Dominio\Usuario\Usuario;
use App\Helper\EntityManagerCreator;
use Doctrine\ORM\EntityRepository;

class RepositorioDePessoaComDoctrine implements RepositorioInterface, RepositorioDePessoa
{
    

    /**
     * @var EntityRepository
     */
    private $registro;

    public function __construct()
    {
        $this->entityManager = EntityManagerCreator::createEntityManager();
        $this->registro = $this->entityManager->getRepository(Pessoa::class);
    }

    public function getRegistro(): EntityRepository
    {
        return $this->registro;
    }

    public function adicionar(Pessoa $pessoa): void
    {
        $this->entityManager->persist($pessoa);
        $this->entityManager->flush();
    }

    public function buscarPorId(int $id): ?Usuario
    {
        $pessoa = $this->registro->find($id);

        return $pessoa;
    }

    public function buscarPorCpf(Cpf $cpf): Pessoa
    {
        //
    }

    public function buscarTodos(): array
    {
        $pessoasLista = $this->registro->findAll();
        return $pessoasLista;
    }

    public function atualizar(int $id, UsuarioDto $pessoaDto): ?Pessoa
    {
        $pessoaExistente = $this->buscarPorId($id);
        if(is_null($pessoaExistente)){
            throw new \InvalidArgumentException();
        }

        $pessoaAtualizada = $pessoaExistente
            ->setDocumento($pessoaDto->documentoUsuario)
            ->setNome($pessoaDto->nomeUsuario)
            ->setEmail($pessoaDto->emailUsuario);
        
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