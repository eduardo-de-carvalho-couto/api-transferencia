<?php

namespace App\Helper;

use App\Infra\Type\TipoCpf;
use App\Infra\Type\TipoEmail;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;

class EntityManagerCreator
{
    public static function createEntityManager(): EntityManagerInterface
    {
        $config = ORMSetup::createXMLMetadataConfiguration(
            [__DIR__ . '/../../db/Mapeamentos']
        );
        $con = [
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . '/../../var/db.sqlite',
        ];

        Type::addType('email', TipoEmail::class);
        Type::addType('cpf', TipoCpf::class);

        $em = EntityManager::create($con, $config);
        $em->getConnection()
        ->getDatabasePlatform()
        ->registerDoctrineTypeMapping('EMAIL', 'email');

        $em->getConnection()
        ->getDatabasePlatform()
        ->registerDoctrineTypeMapping('CPF', 'cpf');

        return $em;
    }
}