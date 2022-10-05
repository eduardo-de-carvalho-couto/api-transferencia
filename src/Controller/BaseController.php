<?php

namespace App\Controller;

use App\Aplicacao\Usuario\UsuarioDto;
use App\Dominio\Usuario\RepositorioInterface;
use App\Helper\ExtratorDadosRequest;
use App\Infra\JsonSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    /**
     * @var RepositorioInterface
     */
    protected $repositorio;
    /**
     * @var ExtratorDadosRequest;
     */
    protected $extratorDadosRequest;

    public function __construct(RepositorioInterface $repositorio, ExtratorDadosRequest $extratorDadosRequest)
    {
        $this->repositorio = $repositorio;
        $this->extratorDadosRequest = $extratorDadosRequest;
    }

    public function buscarTodos(Request $request): Response
    {
        $filtro = $this->extratorDadosRequest->buscarDadosFiltro($request);
        $informacoesDeOrdenacao = $this->extratorDadosRequest->buscarDadosOrdenacao($request);
        [$paginaAtual, $itensPorPagina] = $this->extratorDadosRequest->buscarDadosPaginacao($request);
        
        $entidadeLista = $this->repositorio->getRegistro()->findBy(
            $filtro, 
            $informacoesDeOrdenacao,
            $itensPorPagina,
            ($paginaAtual - 1) * $itensPorPagina
        );
        
        foreach($entidadeLista as $entidade){
            $entidade = new JsonSerializer($entidade);
            $entidade->jsonSerialize();
            $entidades[] = $entidade;
        }
        
        return new JsonResponse($entidades);
    }

    public function buscarUsuario(int $id): Response
    {
        $entidade = $this->repositorio->buscarPorId($id);

        $codigoRetorno = is_null($entidade) ? Response::HTTP_NO_CONTENT : 200;

        $entidade = new JsonSerializer($entidade);
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

        $entidade = new JsonSerializer($entidade);
        $entidade->jsonSerialize();

        return new JsonResponse($entidade);
    }

    public function remove(int $id): Response
    {
        $this->repositorio->remove($id);

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}