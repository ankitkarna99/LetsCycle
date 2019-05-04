<?php

$router->get('/cycle/{id}/appoint', ['middleware' => 'auth', 'uses' => 'CycleController@attachCycle']);
$router->post('/cycle/{id}/bill', ['middleware' => 'auth', 'uses' => 'CycleController@getBill']);