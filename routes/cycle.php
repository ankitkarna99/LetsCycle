<?php

$router->get('/cycle/{id}/appoint', ['middleware' => 'auth', 'uses' => 'CycleController@attachCycle']);
$router->get('/cycle/{id}/bill', ['middleware' => 'auth', 'uses' => 'CycleController@getBill']);
$router->get('/cycle/{id}/pay', ['middleware' => 'auth', 'uses' => 'CycleController@payBill']);