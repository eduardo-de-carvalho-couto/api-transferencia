<?php

namespace App\Controller;

use App\Infra\CifradorDeSenhaPhp;
use App\Infra\RepositoriosComDoctrine\RepositorioDeLojaComDoctrine;
use App\Infra\Usuario\RepositoriosComDoctrine\RepositorioDePessoaComDoctrine;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    private RepositorioDePessoaComDoctrine $repositorioDePessoa;

    private RepositorioDeLojaComDoctrine $repositorioDeLoja;

    private CifradorDeSenhaPhp $cifradorDeSenha;

    public function __construct(
        RepositorioDePessoaComDoctrine $repositorioDePessoa,
        RepositorioDeLojaComDoctrine $repositorioDeLoja,
        CifradorDeSenhaPhp $cifradorDeSenha
    )
    {
        $this->repositorioDePessoa = $repositorioDePessoa;
        $this->repositorioDeLoja = $repositorioDeLoja;
        $this->cifradorDeSenha = $cifradorDeSenha;
    }

    /**
     * @Route("/login", name="login")
     */
    public function index(Request $request)
    {
        $dadosEmJson = json_decode($request->getContent(), true);
        if (!array_key_exists('cpf', $dadosEmJson) && !array_key_exists('cnpj', $dadosEmJson)) {
            return new JsonResponse([
                'erro' => 'Favor enviar Cpf ou Cnpj'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = array_key_exists('cnpj', $dadosEmJson) 
            ? $this->repositorioDeLoja 
            : $this->repositorioDePessoa->getRegistro()->findOneBy([
                'cpf' => $dadosEmJson['cpf']
            ]);
        
        

        if (!$this->cifradorDeSenha->verificar($dadosEmJson['senha'], $user->getSenha())){
            return new JsonResponse([
                'erro' => 'Usuário ou senha inválidos.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = property_exists($user, 'cnpj') 
            ? JWT::encode(['cnpj' => $user->getDocumento()], 'minha_chave_secreta', 'HS256') 
            : JWT::encode(['cpf' => $user->getDocumento()], 'minha_chave_secreta', 'HS256');

        return new JsonResponse([
            'access_token' => $token
        ]);
        
    }
}