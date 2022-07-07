<?php

namespace App\Action\Order;

use App\Domain\Order\Service\OrderCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class OrderCreatorAction
{
    private JsonRenderer $renderer;

    private OrderCreator $orderCreator;

    public function __construct(OrderCreator $orderCreator, JsonRenderer $renderer)
    {
        $this->orderCreator = $orderCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $order = $this->orderCreator->createOrder($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['customer_id' => $order])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
