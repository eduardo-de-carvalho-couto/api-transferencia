<?php

namespace App\Dominio\Usuario\Loja;

use App\Dominio\Cnpj;
use App\Dominio\Email;
use App\Dominio\Usuario\Usuario;

class Loja extends Usuario implements \JsonSerializable
{
    private Cnpj $cnpj;

    public static function comDocumentoNomeEEmail(string $documento, string $nome, string $email, string $senha): self
    {
        return new Loja(new Cnpj($documento), $nome, new Email($email), $senha);
    }

    public function __construct(Cnpj $cnpj, string $nome, Email $email, string $senha)
    {
        parent::__construct($nome, $email, $senha);

        $this->cnpj = $cnpj;
    }

    public function setDocumento(string $cnpj): self
    {
        $this->cnpj = new Cnpj($cnpj);
        return $this;
    }

    public function getDocumento(): string
    {
        return $this->cnpj;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'documento' => $this->getDocumento(),
            'nome' => $this->getNome(),
            'email' => $this->getEmail(),
            '_links' => [
                [
                    'rel' => 'self',
                    'path' => '/lojas/' . $this->getId()
                ],
            ],
        ];
    }
}