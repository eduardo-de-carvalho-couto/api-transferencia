<?php

namespace App\Controller;

use App\Aplicacao\Usuario\Pessoa\RegistrarPessoa\RegistrarPessoa;
use App\Aplicacao\Usuario\Pessoa\RegistrarPessoa\RegistrarPessoaDto;
use App\Dominio\Usuario\Pessoa\Pessoa;
use App\Helper\EntityManagerCreator;
use App\Infra\JsonSerialize;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Infra\Usuario\RepositoriosComDoctrine\RepositorioDePessoaComDoctrine;
use Doctrine\ORM\EntityManagerInterface;

class PessoaController
{
    
    public function __construct()
    {
    }

    /**
     *  @Route("/pessoas", methods={"POST"})
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
        $repositorioDePessoa = new RepositorioDePessoaComDoctrine();
        $pessoasLista = $repositorioDePessoa->buscarTodos();
        
        foreach($pessoasLista as $pessoa){
            $pessoa = new JsonSerialize($pessoa);
            $pessoa->jsonSerialize();
            $pessoas[] = $pessoa;
        }

        return new JsonResponse($pessoas);
    }

    /**
     * @Route("/pessoas/{id}", methods={"GET"})
     */
    public function buscarPessoa(int $id): Response
    {
        $repositorioDePessoa = new RepositorioDePessoaComDoctrine();
        $pessoa = $repositorioDePessoa->buscarPorId($id);

        $codigoRetorno = is_null($pessoa) ? Response::HTTP_NO_CONTENT : 200;

        $pessoa = new JsonSerialize($pessoa);
        $pessoa->jsonSerialize();

        return new JsonResponse($pessoa, $codigoRetorno);
    }

    //Crie o método de atualização
    /**
     * @Route("/pessoas/{id}", methods={"PUT"});
     */
    public function atualizar(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $dadoEmJson = json_decode($corpoRequisicao);

        $dadosPessoa = new RegistrarPessoaDto(
            $dadoEmJson->cpf, 
            $dadoEmJson->nome, 
            $dadoEmJson->email
        );

        $repositorioDePessoa = new RepositorioDePessoaComDoctrine();
        $pessoa = $repositorioDePessoa->atualizar($id, $dadosPessoa);
        if(is_null($pessoa)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $pessoa = new JsonSerialize($pessoa);
        $pessoa->jsonSerialize();

        return new JsonResponse($pessoa);
    }

    /**
     * @Route("/pessoas/{id}", methods={"DELETE"})
     */
    public function remove(int $id): Response
    {
        $repositorioDePessoa = new RepositorioDePessoaComDoctrine();
        $repositorioDePessoa->remove($id);

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}