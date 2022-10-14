<?php

namespace App\Infra\Type;

use App\Dominio\Cnpj;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class TipoCnpj extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'CNPJ';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Cnpj($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function getName()
    {
        return 'cnpj';
    }
}