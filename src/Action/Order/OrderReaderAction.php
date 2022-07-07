<?php

namespace App\Action\Order;

use App\Domain\Order\Data\OrderReaderResult;
use App\Domain\Order\Service\OrderReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class OrderReaderAction
{
    private OrderReader $orderReader;

    private JsonRenderer $renderer;

    public function __construct(OrderReader $orderReader, JsonRenderer $jsonRenderer)
    {
        $this->orderReader = $orderReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $orderId = (int)$args['order_id'];

        // Invoke the domain and get the result
        $order = $this->orderReader->getOrder($orderId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($order));
    }

    private function transform(OrderReaderResult $order): array
    {
        return [
            'id'    => $order->id,
            'name'  => $order->name,
            'phone' => $order->phone,
            'sum'   => $order->sum,
        ];
    }
}
