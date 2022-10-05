<?php

namespace App\Helper;

use App\Dominio\Usuario\Usuario;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    /**
     * @var bool
     */
    private $sucesso;
    /**
     * @var int
     */
    private $paginaAtual;
    /**
     * @var int
     */
    private $itensPorPagina;
    /**
     *  @return Usuario[];
     */
    private $conteudoResposta;
    /**
     * @var int
     */
    private $statusResposta;

    public function __construct(
        bool $sucesso,
        $conteudoResposta,
        int $statusResposta = Response::HTTP_OK,
        int $paginaAtual = null,
        int $itensPorPagina = null
    )
    {
        $this->sucesso = $sucesso;
        $this->paginaAtual = $paginaAtual;
        $this->itensPorPagina = $itensPorPagina;
        $this->conteudoResposta = $conteudoResposta;
        $this->statusResposta = $statusResposta;
    }

    public function getResponse(): Response
    {
        $conteudoResposta = [
            'sucesso' => $this->sucesso,
            'paginaAtual' => $this->paginaAtual,
            'itensPorPagina' => $this->itensPorPagina,
            'conteudoResposta' => $this->conteudoResposta
        ];

        if (is_null($this->paginaAtual)) {
            unset($conteudoResposta['paginaAtual']);
            unset($conteudoResposta['itensPorPagina']);
        }

        return new JsonResponse($conteudoResposta, $this->statusResposta);
    }
}