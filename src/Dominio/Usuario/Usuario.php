<?php

namespace App\Dominio\Usuario;

use App\Dominio\Email;

abstract class Usuario
{
    protected int $id;
    protected string $nome;
    protected Email $email;
    protected string $senha;

    abstract public static function comDocumentoNomeEEmail(string $documento, string $nome, string $email, string $senha): self;

    public function __construct(string $nome, Email $email, string $senha)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    public function getNome(): string
    {
        return $this->nome;
    }
    
    abstract public function getDocumento(): string;

    public function setEmail(string $endereco): self
    {
        $this->email = new Email($endereco);
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}