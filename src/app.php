<?php

use Silex\Application;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\ServicesLoader;
use App\RoutesLoader;

date_default_timezone_set('Europe/Istanbul');
define("ROOT_PATH", __DIR__ . "/..");

$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new HttpFragmentServiceProvider());

/// CORS header sets
$app->before(function (Request $request) {
    if ($request->getMethod() === "OPTIONS") {
        $response = new Response();
        $response->headers->set("Access-Control-Allow-Origin", "*");
        $response->headers->set("Access-Control-Allow-Methods", "GET,POST,PUT,DELETE,OPTIONS");
        $response->headers->set("Access-Control-Allow-Headers", "Content-Type");
        $response->setStatusCode(200);
        return $response->send();
    }
}, Application::EARLY_EVENT);

/// Response header sets
$app->after(function (Request $request, Response $response) {
    $response->headers->set("Access-Control-Allow-Origin", "*");
    $response->headers->set("Access-Control-Allow-Methods", "GET,POST,PUT,DELETE,OPTIONS");
});

/// Request header type set
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

/// Doctrine register
$app->register(new DoctrineServiceProvider(), array(
    "db.options" => array(
        "driver" => "pdo_sqlite",
        "path" => __DIR__ . "/../var/db/app.db",
    ),
));

/// Cache provider register
$app->register(new HttpCacheServiceProvider(), array("http_cache.cache_dir" => ROOT_PATH . "/var/cache"));

/// Monolog register
$app->register(new MonologServiceProvider(), array(
    "monolog.logfile" => ROOT_PATH . "/var/logs/" . (new DateTime())->format("Y-m-d") . ".log",
    "monolog.level" => $app["log.level"],
    "monolog.name" => "application"
));

/// Error part
$app->error(function (\Exception $e, $code) use ($app) {
    $app['monolog']->addError($e->getMessage());
    $app['monolog']->addError($e->getTraceAsString());
    return new JsonResponse(array(
        "statusCode" => $code,
        "message" => $e->getMessage(),
        //"stacktrace" => $e->getTraceAsString()
    ));
});

$servicesLoader = new ServicesLoader($app);
$servicesLoader->bindServicesIntoContainer();

$routesLoader = new RoutesLoader($app);
$routesLoader->bindRoutesToControllers();

return $app;
