<?php

namespace App\Dominio\Usuario\Loja;

use App\Dominio\Cnpj;
use App\Dominio\Email;
use App\Dominio\Usuario\Usuario;

class Loja extends Usuario
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

    public function getDocumento(): string
    {
        return $this->cnpj;
    }
}