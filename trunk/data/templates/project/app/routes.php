<?php

$clientGroup = $routes->create();
$managerGroup = $routes->create();

$routes->add()
    ->using($clientGroup)
    ->url('/')
    ->action('IndexController', 'index')
    ->view(B_APP.'views/client/index.xsl');

$routes->add()
    ->using($managerGroup)
    ->url('/manager/')
    ->action('ManagerController', 'index')
    ->view(B_APP.'views/manager/index.xsl');
