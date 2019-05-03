<?php

$router->get('/user/balance', ['middleware' => 'auth', 'uses' => 'UserController@getBalance']);