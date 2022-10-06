<?php

namespace App\Controller;

use App\Aplicacao\Usuario\Pessoa\RegistrarPessoa\RegistrarPessoa;
use App\Aplicacao\Usuario\Pessoa\RegistrarPessoa\RegistrarPessoaDto;
use App\Helper\ExtratorDadosRequest;
use App\Infra\CifradorDeSenhaPhp;
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
    /**
     * @var CifradorDeSenhaPhp
     */
    private $cifradorDeSenhaPhp;

    public function __construct(RepositorioDePessoaComDoctrine $pessoasRepositorio, CifradorDeSenhaPhp $cifradorDeSenhaPhp, ExtratorDadosRequest $extratorDadosRequest)
    {
        parent::__construct($pessoasRepositorio, $extratorDadosRequest);
        $this->pessoasRepositorio = $pessoasRepositorio;
        $this->cifradorDeSenhaPhp = $cifradorDeSenhaPhp;
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
        $cifradorDeSenha = $this->cifradorDeSenhaPhp;
        
        $useCase = new RegistrarPessoa($repositorioDePessoa, $cifradorDeSenha);
        $useCase->executa($dadosPessoa, $dadoEmJson->senha);

        return new JsonResponse($dadosPessoa);
    }

}