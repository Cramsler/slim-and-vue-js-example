<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Repository\OrderRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class OrderUpdater
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
        $this->orderValidator = $orderValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('order_updater.log')
            ->createLogger();
    }

    public function updateOrder(int $orderId, array $data): void
    {
        // Input validation
        $this->orderValidator->validateOrderUpdate($orderId, $data);

        // Update the row
        $this->repository->updateOrder($orderId, $data);

        // Logging
        $this->logger->info(sprintf('Order updated successfully: %s', $orderId));
    }
}
