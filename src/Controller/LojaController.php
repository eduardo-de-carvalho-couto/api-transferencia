<?php

namespace App\Controller;

use App\Aplicacao\Usuario\Loja\RegistrarLoja\RegistrarLoja;
use App\Aplicacao\Usuario\Loja\RegistrarLoja\RegistrarLojaDto;
use App\Helper\ExtratorDadosRequest;
use App\Infra\CifradorDeSenhaPhp;
use App\Infra\RepositoriosComDoctrine\RepositorioDeLojaComDoctrine;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LojaController extends BaseController
{
    /**
     * @var RepositorioDeLojaComDoctrine
     */
    private $repositorioDeLoja;
    /**
     * @var CifradorDeSenhaPhp
     */
    private $cifradorDeSenha;
    
    public function __construct(RepositorioDeLojaComDoctrine $repositorioDeLoja, CifradorDeSenhaPhp $cifradorDeSenha, ExtratorDadosRequest $extratorDadosRequest)
    {
        parent::__construct($repositorioDeLoja, $extratorDadosRequest);
        $this->repositorioDeLoja = $repositorioDeLoja;
        $this->cifradorDeSenha = $cifradorDeSenha;
    }
    /**
     * @Route("/lojas", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $dadoEmJson = json_decode($corpoRequisicao);

        $dadosLoja = new RegistrarLojaDto(
            $dadoEmJson->documento,
            $dadoEmJson->nome,
            $dadoEmJson->email
        );

        $repositorioDeLoja = $this->repositorioDeLoja;
        $cifradorDeSenha = $this->cifradorDeSenha;

        $useCase = new RegistrarLoja($repositorioDeLoja, $cifradorDeSenha);
        $useCase->executa($dadosLoja, $dadoEmJson->senha);

        return new JsonResponse($dadosLoja);
    }
}