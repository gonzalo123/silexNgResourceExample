<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;
use Silex\Application;

$app          = new Silex\Application();
$app['debug'] = true;

$app['routes'] = $app->extend(
    'routes',
    function (RouteCollection $routes, Application $app) {
        $loader     = new YamlFileLoader(new FileLocator(__DIR__ . '/config'));
        $collection = $loader->load('routes.yml');
        $routes->addCollection($collection);

        return $routes;
    }
);

$app->register(
    new Silex\Provider\DoctrineServiceProvider(),
    array(
        'db.options' => array(
            'driver' => 'pdo_sqlite',
            'path'   => __DIR__ . '/db/app.db.sqlite',
        ),
    )
);

$app->run();