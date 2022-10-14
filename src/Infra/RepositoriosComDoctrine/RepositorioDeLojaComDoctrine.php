<?php

namespace App\Infra\RepositoriosComDoctrine;

use App\Aplicacao\Usuario\UsuarioDto;
use App\Dominio\Cnpj;
use App\Dominio\Usuario\Loja\Loja;
use App\Dominio\Usuario\Loja\RepositorioDeLoja;
use App\Dominio\Usuario\RepositorioInterface;
use App\Dominio\Usuario\Usuario;
use App\Helper\EntityManagerCreator;
use Doctrine\ORM\EntityRepository;

class RepositorioDeLojaComDoctrine implements RepositorioInterface, RepositorioDeLoja
{
    /**
     *  @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $registro;

    public function __construct()
    {
        $this->entityManager = EntityManagerCreator::createEntityManager();
        $this->registro = $this->entityManager->getRepository(Loja::class);
    }

    public function getRegistro(): EntityRepository
    {
        return $this->registro;
    }

    public function buscarPorId(int $id): ?Usuario
    {
        $loja = $this->registro->find($id);

        return $loja;
    }

    public function buscarTodos(): array
    {
        $lojasLista = $this->registro->findAll();
        return $lojasLista;
    }

    public function atualizar(int $id, UsuarioDto $lojaDto): ?Usuario
    {
        $lojaExistente = $this->buscarPorId($id);
        if(is_null($lojaExistente)){
            throw new \InvalidArgumentException();
        }

        $lojaAtualizada = $lojaExistente
            ->setDocumento($lojaDto->documentoUsuario)
            ->setNome($lojaDto->nomeUsuario)
            ->setEmail($lojaDto->emailUsuario);
        
        $this->entityManager->flush();
        return $lojaAtualizada;
    }

    public function remove(int $id): void
    {
        $loja = $this->buscarPorId($id);
        $this->entityManager->remove($loja);
        $this->entityManager->flush();
    }

    public function adicionar(Loja $loja): void
    {
        $this->entityManager->persist($loja);
        $this->entityManager->flush();
    }

    public function buscarPorCnpj(Cnpj $cnpj): Loja
    {
        //
    }
}