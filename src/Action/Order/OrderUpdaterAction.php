<?php

namespace App\Action\Order;

use App\Domain\Order\Service\OrderUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class OrderUpdaterAction
{
    private OrderUpdater $orderUpdater;

    private JsonRenderer $renderer;

    public function __construct(OrderUpdater $orderUpdater, JsonRenderer $jsonRenderer)
    {
        $this->orderUpdater = $orderUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Extract the form data from the request body
        $orderId = (int)$args['order_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->orderUpdater->updateOrder($orderId, $data);

        // Build the HTTP response
        return $this->renderer->json($response);
    }
}
