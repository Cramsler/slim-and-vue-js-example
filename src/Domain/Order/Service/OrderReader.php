<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Data\OrderReaderResult;
use App\Domain\Order\Repository\OrderRepository;

/**
 * Service.
 */
final class OrderReader
{
    private OrderRepository $repository;

    /**
     * The constructor.
     *
     * @param OrderRepository $repository The repository
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read an order.
     *
     * @param int $orderId The order id
     *
     * @return OrderReaderResult The result
     */
    public function getOrder(int $orderId): OrderReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $orderRow = $this->repository->getOrderById($orderId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result        = new OrderReaderResult();
        $result->id    = $orderRow['id'];
        $result->name  = $orderRow['name'];
        $result->phone = $orderRow['phone'];
        $result->sum   = $orderRow['sum'];

        return $result;
    }
}
