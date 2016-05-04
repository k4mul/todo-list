<?php

$app->post('/create', 'TaskController:create');

$app->get('/', 'TaskController:index');
$app->get('/all', 'TaskController:all');
$app->get('/change-status/{id}', 'TaskController:changeStatus');
$app->get('/delete/{id}', 'TaskController:delete');