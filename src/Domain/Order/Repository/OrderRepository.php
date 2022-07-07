<?php

namespace App\Domain\Order\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class OrderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function insertOrder(array $order): int
    {
        return (int)$this->queryFactory->newInsert('orders', $this->toRow($order))
            ->execute()
            ->lastInsertId();
    }

    public function getOrderById(int $orderId): array
    {
        $query = $this->queryFactory->newSelect('orders');
        $query->select(
            [
                'id',
                'name',
                'phone',
                'sum'
            ]
        );

        $query->where(['id' => $orderId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Order not found: %s', $orderId));
        }

        return $row;
    }

    public function updateOrder(int $orderId, array $order): void
    {
        $row = $this->toRow($order);

        $this->queryFactory->newUpdate('orders', $row)
            ->where(['id' => $orderId])
            ->execute();
    }

    public function existsOrderId(int $orderId): bool
    {
        $query = $this->queryFactory->newSelect('orders');
        $query->select('id')->where(['id' => $orderId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteOrderById(int $orderId): void
    {
        $this->queryFactory->newDelete('orders')
            ->where(['id' => $orderId])
            ->execute();
    }

    private function toRow(array $order): array
    {
        return [
            'phone' => $order['phone'],
            'name'  => $order['name'],
            'sum'   => $order['sum'],
        ];
    }
}
