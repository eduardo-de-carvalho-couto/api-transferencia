<?php

namespace App\Dominio\Usuario;

use App\Dominio\Email;

abstract class Usuario 
{
    protected int $id;
    protected string $nome;
    protected Email $email;
    protected string $senha;

    abstract public static function comDocumentoNomeEEmail(string $documento, string $nome, string $email): self;

    public function __construct(string $nome, Email $email)
    {
        $this->nome = $nome;
        $this->email = $email;
    }

    public function getNome(): string
    {
        return $this->nome;
    }
    
    abstract public function getDocumento(): string;

    public function getEmail(): string
    {
        return $this->email;
    }
}