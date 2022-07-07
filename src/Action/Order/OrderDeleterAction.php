<?php

namespace App\Action\Order;

use App\Domain\Order\Service\OrderDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class OrderDeleterAction
{
    private OrderDeleter $orderDeleter;

    private JsonRenderer $renderer;

    public function __construct(OrderDeleter $orderDeleter, JsonRenderer $renderer)
    {
        $this->orderDeleter = $orderDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $orderId = (int)$args['order_id'];

        // Invoke the domain (service class)
        $this->orderDeleter->deleteOrder($orderId);

        // Render the json response
        return $this->renderer->json($response);
    }
}
