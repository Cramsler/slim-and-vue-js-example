<?php

namespace App\Domain\Order\Repository;

use App\Factory\QueryFactory;

final class OrderFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findOrders(): array
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

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
