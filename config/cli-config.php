<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Helper\EntityManagerCreator;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;

$config = new PhpFile(__DIR__ . '/migrations.php');

$entityManager = EntityManagerCreator::createEntityManager();

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));