<?php

$router->get('/kyc', ['middleware' => 'auth', 'uses' => 'KYCFormController@getKYC']);
$router->post('/kyc', ['middleware' => 'auth', 'uses' => 'KYCFormController@insertKYC']);
