<?php

namespace App\Controller;

use App\Aplicacao\Usuario\Pessoa\RegistrarPessoa\RegistrarPessoa;
use App\Aplicacao\Usuario\Pessoa\RegistrarPessoa\RegistrarPessoaDto;
use App\Dominio\Usuario\Pessoa\Pessoa;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Infra\Usuario\RepositoriosComDoctrine\RepositorioDePessoaComDoctrine;

class PessoaController
{

    public function __construct()
    {
    }

    /**
     *  @Route("/pessoa", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $dadoEmJson = json_decode($corpoRequisicao);

        $dadosPessoa = new RegistrarPessoaDto(
            $dadoEmJson->cpf, 
            $dadoEmJson->nome, 
            $dadoEmJson->email
        );

        $repositorioDePessoa = new RepositorioDePessoaComDoctrine();
        
        $useCase = new RegistrarPessoa($repositorioDePessoa);
        $useCase->executa($dadosPessoa);

        return new JsonResponse($dadosPessoa);
    }


    /**
     * @Route("/pessoas", methods={"GET"})
     */
    public function buscarTodos(): Response
    {
        $repositorioDePessoas = $this->entityManager->getRepository(Pessoa::class);

        $pessoaLista = $repositorioDePessoas->findAll();

        return new JsonResponse($pessoaLista);
    }

    /**
     * @Route("/pessoa/{id}", methods={"GET"})
     */
    public function buscarPessoa(int $id): Response
    {
        $repositorioDePessoas = $this->entityManager->getRepository(Pessoa::class);
        
        $pessoa = $repositorioDePessoas->find($id);
        $codigoRetorno = is_null($pessoa) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($pessoa, $codigoRetorno);
    }

    //Crie o método de atualização
}