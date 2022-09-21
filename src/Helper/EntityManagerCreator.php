<?php

namespace App\Helper;

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

        return EntityManager::create($con, $config);
    }
}