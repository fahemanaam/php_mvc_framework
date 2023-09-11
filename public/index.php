<?php
use app\controllers\AuthController;
use app\controllers\PostController;
use app\core\Application;
use app\controllers\SitController;
require_once __DIR__ . '/../vendor/autoload.php';
// to Installation is super-easy via Composer use commandline:
//$ composer require vlucas/phpdotenv;
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config= [
    'userClass'=> \app\models\User::class,
    'db'=>[
    'dsn'=>$_ENV['DB_DSN'],
    'user'=>$_ENV['DB_USER'],
    'password'=>$_ENV['DB_PASSWORD'],
        ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SitController::class, 'home'] );
$app->router->get('/posts/', [PostController::class, 'show']);
$app->router->get('/contact',[SitController::class, 'contact'] );
$app->router->post('/contact/',[SitController::class, 'contact'] );
$app->router->get('/about',[SitController::class,'about']);
$app->router->get('/login',[AuthController::class,'login']);
$app->router->get('/post',[PostController::class,'addPost']);
$app->router->post('/post',[PostController::class,'addPost']);
$app->router->post('/login',[AuthController::class,'login']);
$app->router->get('/register',[AuthController::class,'register']);
$app->router->post('/register',[AuthController::class,'register']);
$app->router->get('/logout',[AuthController::class,'logout']);
$app->router->get('/profile',[AuthController::class,'profile']);
$app->router->delete('/{id}',[PostController::class,'delete']);
$app->router->get('/edit/{id}', [PostController::class, 'edit']);
$app->router->post('/posts', [PostController::class, 'update']);
$app->run();




