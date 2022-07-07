<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Data\OrderFinderItem;
use App\Domain\Order\Data\OrderFinderResult;
use App\Domain\Order\Repository\OrderFinderRepository;

final class OrderFinder
{
    private OrderFinderRepository $repository;

    public function __construct(OrderFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findOrders(): OrderFinderResult
    {
        // Input validation
        // ...

        $orders = $this->repository->findOrders();

        return $this->createResult($orders);
    }

    private function createResult(array $orderRows): OrderFinderResult
    {
        $result = new OrderFinderResult();

        foreach ($orderRows as $orderRow) {
            $order        = new OrderFinderItem();
            $order->id    = $orderRow['id'];
            $order->name  = $orderRow['name'];
            $order->phone = $orderRow['phone'];
            $order->sum   = $orderRow['sum'];

            $result->orders[] = $order;
        }

        return $result;
    }
}
