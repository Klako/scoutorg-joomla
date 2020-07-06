<?php

$ds = DIRECTORY_SEPARATOR;

require __DIR__ . "/../vendor/autoload.php";

use MockServer\CustomLists;
use MockServer\GroupInfo;
use MockServer\Members;
use Slim\Factory\AppFactory;

$db = new \PDO('sqlite:' . __DIR__ . "/membernet.db");
$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

$app = AppFactory::create();

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    'users' => [
        \getenv('MOCKSERVER_GROUP_ID') => \getenv('MOCKSERVER_GROUP_KEY')
    ],
    'before' => function ($request, $arguments) {
        return $request->withAttribute('groupId', $arguments['user']);
    },
    'secure' => false
]));

$app->get('/api/organisation/group', new GroupInfo($db));
$app->get('/api/group/memberlist', new Members($db));
$app->get('/api/group/customlists', new CustomLists($db));

$app->run();
