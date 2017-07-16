<?php

require_once 'vendor/autoload.php';
// ArangoDB PHP Driver still uses PSR-0 autoloader, so we require this PSR-0 autoloader here
require_once 'vendor/triagens/arangodb/autoload.php';

use Silex\Application;
use App\Providers\ControllerServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use App\Providers\ArangoConnectionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\Yaml\Yaml;

$app = new Application();

$config = Yaml::parse(file_get_contents('app.yml'));

$app['config'] = $config;
$app['debug'] = $app['config']['application']['debug'];

/**
 * Services
 */


/**
 * Providers
 */
$app->register(new ServiceControllerServiceProvider());
$app->register(new ControllerServiceProvider());
$app->register(new ArangoConnectionServiceProvider());
$app->register(new TwigServiceProvider(), [
    'twig.path' => 'views'
]);


// Home
$app->get('/', 'home:index');
$app->get('/create', 'home:getCreate');
$app->post('/store', 'home:postCreate');
$app->get('/edit/{id}', 'home:getUpdate');
$app->post('/update/{id}', 'home:postUpdate');
$app->post('/delete/{id}', 'home:delete');

return $app;
