<?php

// kontener dic
$container = $app->getContainer();

// serwisy
$container['pdo'] = function ($c) {
    $dbfile = $c->get('settings')['db_file'];
    $dsn = 'sqlite:' . $dbfile;
    
    $pdo = new PDO($dsn);
    
    return $pdo;  
};

$container['TaskRepository'] = function ($c) {
    $pdo = $c->get('pdo');
    
    return new ToDo\Task\TaskRepository($pdo);  
};

$container['TaskService'] = function ($c) {
    $repository = $c->get('TaskRepository');
    
    return new ToDo\Service\TaskService($repository);  
};

// kontrolery
$container['TaskController'] = function ($c) {
    $service = $c->get('TaskService');
    
    return new ToDo\Controller\TaskController($service);
};
