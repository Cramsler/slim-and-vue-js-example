<?php

// Define app routes

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Tuupola\Middleware\HttpBasicAuthentication;

return function (App $app) {
    // Redirect to Swagger documentation
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');

    // Swagger API documentation
    $app->get('/docs/v1', \App\Action\OpenApi\Version1DocAction::class)->setName('docs');

    // Password protected area
    $app->group(
        '/api',
        function (RouteCollectorProxy $app) {
            $app->get('/orders', \App\Action\Order\OrderFinderAction::class);
            $app->post('/orders', \App\Action\Order\OrderCreatorAction::class);
            $app->get('/orders/{order_id}', \App\Action\Order\OrderReaderAction::class);
            $app->put('/orders/{order_id}', \App\Action\Order\OrderUpdaterAction::class);
            $app->delete('/orders/{order_id}', \App\Action\Order\OrderDeleterAction::class);
        }
    )->add(HttpBasicAuthentication::class);
};
