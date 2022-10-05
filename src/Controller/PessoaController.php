<?php

namespace App\Controller;

use App\Aplicacao\Usuario\Pessoa\RegistrarPessoa\RegistrarPessoa;
use App\Aplicacao\Usuario\Pessoa\RegistrarPessoa\RegistrarPessoaDto;
use App\Helper\ExtratorDadosRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Infra\Usuario\RepositoriosComDoctrine\RepositorioDePessoaComDoctrine;

class PessoaController extends BaseController
{
    /**
     * @var RepositorioDePessoaComDoctrine
     */
    private $pessoasRepositorio;

    public function __construct(RepositorioDePessoaComDoctrine $pessoasRepositorio, ExtratorDadosRequest $extratorDadosRequest)
    {
        parent::__construct($pessoasRepositorio, $extratorDadosRequest);
        $this->pessoasRepositorio = $pessoasRepositorio;
    }

    /**
     *  @Route("/pessoas", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $dadoEmJson = json_decode($corpoRequisicao);

        $dadosPessoa = new RegistrarPessoaDto(
            $dadoEmJson->documento, 
            $dadoEmJson->nome, 
            $dadoEmJson->email
        );

        $repositorioDePessoa = $this->pessoasRepositorio;
        
        $useCase = new RegistrarPessoa($repositorioDePessoa);
        $useCase->executa($dadosPessoa);

        return new JsonResponse($dadosPessoa);
    }

}