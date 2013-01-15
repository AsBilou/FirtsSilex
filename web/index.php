<?php
// web/index.php

//Include toutes les dépendances
require_once __DIR__.'/../vendor/autoload.php';

//Crée une nouvelle application
$app = new Silex\Application();

//Affiche les bug
$app['debug']=true;

//Mise en route de twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

//routing 
/*
$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});
*/

//Appel d'un template twig 'hello.twig'
/*
$app->get('/hello/{name}', function ($name) use ($app) {
    return $app['twig']->render('template/hello.twig', array(
        'name' => $name,
    ));
});
*/

//Appel le fichier twig en fonction de la page
$app->get('/{name}', function ($name) use ($app) {
    try{
        return $app['twig']->render('template/'.$name.'.twig', array(
            'name' => $name,
            'page'=>'page'.$name,
        ));
    }catch(Exception $e){
        if('Twig_Error_Loader'==get_class($e)){
            $app->abort(404,'Twig template does not exist.');
        }
        else
        {
            throw $e;
        }
    }
});

$app->run();

?>