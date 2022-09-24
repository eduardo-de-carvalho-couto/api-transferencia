<?php

namespace App\Infra\Type;

use App\Dominio\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class TipoEmail extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'EMAIL';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Email($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function getName()
    {
        return 'email';
    }
}