<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Repository\OrderRepository;

final class OrderDeleter
{
    private OrderRepository $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteOrder(int $orderId): void
    {
        // Input validation
        // ...

        $this->repository->deleteOrderById($orderId);
    }
}
