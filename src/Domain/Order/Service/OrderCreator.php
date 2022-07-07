<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Service\OrderValidator;
use App\Domain\Order\Repository\OrderRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class OrderCreator
{
    private OrderRepository $repository;

    private OrderValidator $orderValidator;

    private LoggerInterface $logger;

    public function __construct(
        OrderRepository $repository,
        OrderValidator  $orderValidator,
        LoggerFactory   $loggerFactory
    ) {
        $this->repository = $repository;
        $this->orederValidator = $orderValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('order_creator.log')
            ->createLogger();
    }

    public function createOrder(array $data): int
    {
        // Input validation
        $this->orederValidator->validateOrder($data);

        // Insert customer and get new customer ID
        $orderId = $this->repository->insertOrder($data);

        // Logging
        $this->logger->info(sprintf('Order created successfully: %s', $orderId));

        return $orderId;
    }
}
