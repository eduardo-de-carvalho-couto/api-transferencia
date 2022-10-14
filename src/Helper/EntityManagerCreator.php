<?php

namespace App\Helper;

use App\Infra\Type\TipoCnpj;
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

        
        if (!Type::hasType('email')) {
            Type::addType('email', TipoEmail::class);
        }
        if (!Type::hasType('cpf')) {
            Type::addType('cpf', TipoCpf::class);
        }
        if (!Type::hasType('cnpj')) {
            Type::addType('cnpj', TipoCnpj::class);
        }
        
        $em = EntityManager::create($con, $config);
        $em->getConnection()
        ->getDatabasePlatform()
        ->registerDoctrineTypeMapping('EMAIL', 'email');

        $em->getConnection()
        ->getDatabasePlatform()
        ->registerDoctrineTypeMapping('CPF', 'cpf');

        $em->getConnection()
        ->getDatabasePlatform()
        ->registerDoctrineTypeMapping('CNPJ', 'cnpj');

        return $em;
    }
}