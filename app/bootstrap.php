<?php

if(!defined('JAZZ_PROJECT_ROOT_DIR')) {
    define('JAZZ_PROJECT_ROOT_DIR', dirname(__DIR__));
    define('JAZZ_CONFIG_DIR', JAZZ_PROJECT_ROOT_DIR . '/app/config');
    define('JAZZ_SRC_DIR', JAZZ_PROJECT_ROOT_DIR . '/src');
    define('JAZZ_SRC_JAZZ_DIR', JAZZ_SRC_DIR . '/Jazz');
    define('JAZZ_WEB_DIR', JAZZ_PROJECT_ROOT_DIR.'/web');
}

//use Jazz\Application;
require_once __DIR__ . '/../vendor/autoload.php';
require_once JAZZ_SRC_DIR . '/Helper/helper.php';

$config = getConfig();
$app = new \Jazz\Application(JAZZ_PROJECT_ROOT_DIR, true);

$cfg[] = JAZZ_WEB_DIR.'/themes/'.$config['general']['themes_name']['theme_admin'];
$cfg[] = JAZZ_WEB_DIR.'/themes/'.$config['general']['themes_name']['theme_front'];

$app->register(new \Silex\Provider\SessionServiceProvider(), array(
    'session.storage.options' => array(
        'name' => $config['general']['session']['session_name'],
        'cookie_lifetime' => $config['general']['session']['cookie_lifetime'],
        'cookie_domain' => $config['general']['session']['cookie_domain'],
    ),
));

$app->register(new \Silex\Provider\ServiceControllerServiceProvider()); // register ServiceControllerServiceProvider
$app->register(new \Silex\Provider\SwiftmailerServiceProvider()); // register swift mailer service provider
$app->register(new \Silex\Provider\UrlGeneratorServiceProvider()); // register urlGeneratorService
$app->register(new \Silex\Provider\FormServiceProvider());

// register monolog service provider
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/logs/development.log',
));

// register doctrine service provider

$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => $config['general']['database']['database_driver'],
        'dbname'   => $config['general']['database']['database_name'],
        'host'     => $config['general']['database']['database_host'],
        'user'     => $config['general']['database']['database_user'],
        'password' => $config['general']['database']['database_password'],
    ),
));


// register httpCache service provider
$app->register(new \Silex\Provider\HttpCacheServiceProvider(), array(
    'http_cache.cache_dir' => __DIR__.'/cache',
));

// routing config

/*
// web profiler service
$app->register($provider = new \Silex\Provider\WebProfilerServiceProvider());
$app->mount('/_profile', $provider);
*/

// INJECTING DEFAULT RESOURCE
$app->inject(array(
    'routing.resource' => __DIR__ . '/config/routing.yml',
    'routing.options' => array(
        'cache_dir' => $app['root_dir'] . '/app/cache/routing',
    ),
    'twig.path' => $cfg,
    'twig.option' => array(
        'debug' => true,
        'charset' => 'utf8',
        'cache' => $app['root_dir'] . '/app/cache/twig',
        'strict_variables' => false,
        'autoescape' => true,
    ),
));

$app['twig']->addExtension(new \Jazz\Twig\TwigExtension($app));
$app['twig']->addTokenParser(new \Jazz\Twig\SetContentTokenParser());
$loader = new Twig_Loader_String();
$app['twig.loader']->addLoader($loader);
