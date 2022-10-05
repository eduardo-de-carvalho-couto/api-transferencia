<?php

namespace App\Controller;

use App\Aplicacao\Usuario\UsuarioDto;
use App\Dominio\Usuario\RepositorioInterface;
use App\Helper\ExtratorDadosRequest;
use App\Helper\ResponseFactory;
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
        
        $fabricaResposta = new ResponseFactory(
            true,
            $entidadeLista,
            Response::HTTP_OK,
            $paginaAtual,
            $itensPorPagina
        );
        
        return $fabricaResposta->getResponse();
    }

    public function buscarUsuario(int $id): Response
    {
        $entidade = $this->repositorio->buscarPorId($id);

        $statusResposta = is_null($entidade) 
            ? Response::HTTP_NO_CONTENT 
            : Response::HTTP_OK;

        $fabricaResposta = new ResponseFactory(
            true,
            $entidade,
            $statusResposta
        );

        return $fabricaResposta->getResponse();
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

        try {
            $entidade = $this->repositorio->atualizar($id, $dadosEntidade);
            
            $fabrica = new ResponseFactory(
                true,
                $entidade,
                Response::HTTP_OK
            );

            return $fabrica->getResponse();
        } catch (\InvalidArgumentException $ex) {
            $fabrica = new ResponseFactory(
                false,
                'Recurso não encontrado',
                Response::HTTP_NOT_FOUND
            );

            return $fabrica->getResponse();
        }
    }

    public function remove(int $id): Response
    {
        $this->repositorio->remove($id);

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}