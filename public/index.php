<?php

require_once __DIR__.'/../vendor/autoload.php';


//todo this database logic should be refactored into a config file that gets loaded on a per environment basis
ORM::configure('sqlite:../db/dbsqlite');
if (getenv('VAGRANT')) {
    ORM::configure('mysql:host=localhost;dbname=lorman');
    ORM::configure('username', 'lorman');
    ORM::configure('password', 'lorman');
}

$app = new Silex\Application();
$app['debug'] = true;


/* ------------------------- START DEFINE SERVICES --------------------------- */
$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => __DIR__.'/views',
    )
);
$app->extend(
    'twig',
    function ($twig, $app) {
        $twig->addExtension(new App\TwigExtension\ErrorExtension());

        return $twig;
    }
);
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app['swiftmailer.options'] = array(
    'host' => '127.0.0.1',
    'port' => '1025',
    'username' => 'username',
    'password' => 'password',
    'encryption' => null,
    'auth_mode' => null,
);


$app['contact_form_mailer'] = function ($app) {
    return new \App\Mailer\ContactFormMailer($app['mailer']);
};


$app['main.controller'] = function () use ($app) {
    return new \App\Controller\MainController($app['contact_form_mailer']);
};


/* ------------------------- END DEFINE SERVICES --------------------------- */


/* ------------------------- START DEFINE ROUTES --------------------------- */

$app->get(
    '/',
    'main.controller:indexAction'
)->bind('main_index');

$app->post(
    '/',
    'main.controller:indexAction'
)->bind('main_index_post');


/* ------------------------- END DEFINE ROUTES --------------------------- */


$app->run();