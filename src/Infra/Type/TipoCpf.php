<?php

namespace App\Infra\Type;

use App\Dominio\Cpf;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class TipoCpf extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'CPF';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Cpf($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function getName()
    {
        return 'cpf';
    }
}