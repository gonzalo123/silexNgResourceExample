<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;
use Silex\Application;


$app = new Silex\Application();
$app['debug'] = true;

$app['routes'] = $app->extend('routes', function (RouteCollection $routes, Application $app) {
    $loader     = new YamlFileLoader(new FileLocator(__DIR__ . '/config'));
    $collection = $loader->load('routes.yml');
    $routes->addCollection($collection);

    return $routes;
});

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_sqlite',
        'path'   => __DIR__ . '/db/app.db.sqlite',
    ),
));
/*
$app->mount('/message', new Message\MessageControllerProvider());$app->run();die();

$app->get('/message', function () use ($app) {
    return new JsonResponse($app['db']->fetchAll("SELECT * FROM messages"));
});

$app->get('/message/{id}', function ($id) use ($app) {
    return new JsonResponse($app['db']->fetchAssoc("SELECT * FROM messages WHERE id=:ID", ['ID' => $id]));
});

$app->delete('/message/{id}', function ($id) use ($app) {
    return $app['db']->delete('messages', ['ID' => $id]);
});

$app->post('/message', function (Request $request) use ($app) {
    $newId = (integer)$app['db']->fetchColumn("SELECT max(id) FROM messages") + 1;

    return $app['db']->insert('messages', [
        'ID'      => $newId,
        'AUTHOR'  => $request->get('author'),
        'MESSAGE' => $request->get('message'),
    ]);
});
*/


$app->run();