<?php

namespace App\Controller;

use App\Aplicacao\Usuario\UsuarioDto;
use App\Dominio\Usuario\RepositorioInterface;
use App\Infra\JsonSerialize;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Dominio\Usuario\Pessoa\RepositorioDePessoa;

abstract class BaseController extends AbstractController
{
    /**
     * @var RepositorioInterface
     */
    protected $repositorio;

    public function __construct(RepositorioInterface $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    public function buscarTodos(): Response
    {
        $entidadeLista = $this->repositorio->buscarTodos();
        
        foreach($entidadeLista as $entidade){
            $entidade = new JsonSerialize($entidade);
            $entidade->jsonSerialize();
            $entidades[] = $entidade;
        }

        return new JsonResponse($entidades);
    }

    public function buscarUsuario(int $id): Response
    {
        $entidade = $this->repositorio->buscarPorId($id);

        $codigoRetorno = is_null($entidade) ? Response::HTTP_NO_CONTENT : 200;

        $entidade = new JsonSerialize($entidade);
        $entidade->jsonSerialize();

        return new JsonResponse($entidade, $codigoRetorno);
    }

    public function atualizar(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $dadoEmJson = json_decode($corpoRequisicao);

        $dadosEntidade = new UsuarioDto(
            $dadoEmJson->documento, 
            $dadoEmJson->nome, 
            $dadoEmJson->email
        );

        $entidade = $this->repositorio->atualizar($id, $dadosEntidade);
        if(is_null($entidade)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $entidade = new JsonSerialize($entidade);
        $entidade->jsonSerialize();

        return new JsonResponse($entidade);
    }

    public function remove(int $id): Response
    {
        $this->repositorio->remove($id);

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}