<?php

$router->get('/cycle/{id}/appoint', ['middleware' => 'auth', 'uses' => 'CycleController@attachCycle']);
$router->post('/cycle/{id}/pay', ['middleware' => 'auth', 'uses' => 'CycleController@payForCycle']);