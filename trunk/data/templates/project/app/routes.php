<?php

$routes->add()
    ->using($clientGroup)
    ->url('/')
    ->action('rIndexController', 'index')
    ->view(B_APP.'views/index.xsl');

$dispatcher->setRoutes($routes);
