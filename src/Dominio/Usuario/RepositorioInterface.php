<?php

namespace App\Dominio\Usuario;

use App\Aplicacao\Usuario\UsuarioDto;

interface RepositorioInterface
{
    public function buscarPorId(int $id): ?Usuario;
    /** @return Usuario[] */
    public function buscarTodos(): array;
    public function atualizar(int $id, UsuarioDto $usuarioDto);
    public function remove(int $id): void;
}