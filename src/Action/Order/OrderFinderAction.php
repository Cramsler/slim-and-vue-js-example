<?php

namespace App\Action\Order;

use App\Domain\Order\Data\OrderFinderResult;
use App\Domain\Order\Service\OrderFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class OrderFinderAction
{
    private OrderFinder $orderFinder;

    private JsonRenderer $renderer;

    public function __construct(OrderFinder $orderFinder, JsonRenderer $jsonRenderer)
    {
        $this->orderFinder = $orderFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $orders = $this->orderFinder->findOrders();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($orders));
    }

    public function transform(OrderFinderResult $collection): array
    {
        $orders = [];

        foreach ($collection->orders as $order)
        {
            $orders[] = [
                'id'    => $order->id,
                'name'  => $order->name,
                'phone' => $order->phone,
                'sum'   => $order->sum,
            ];
        }

        return [
            'orders' => $orders,
        ];
    }
}
