<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Repository\OrderRepository;
use App\Support\Validation;
use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;

final class OrderValidator
{
    private OrderRepository $repository;

    private Validation $validation;

    public function __construct(OrderRepository $repository, Validation $validation)
    {
        $this->repository = $repository;
        $this->validation = $validation;
    }

    public function validateOrderUpdate(int $orderId, array $data): void
    {
        if (!$this->repository->existsOrderId($orderId)) {
            throw new ValidationException(sprintf('Order not found: %s', $orderId));
        }

        $this->validateOrder($data);
    }

    public function validateOrder(array $data): void
    {
        $validator = $this->createValidator();
        $validationResult = $this->validation->validate($validator, $data);

        if ($validationResult->fails()) {
            throw new ValidationException('Please check your input', $validationResult);
        }
    }

    private function createValidator(): Validator
    {
        $validator = $this->validation->createValidator();

        return $validator
            ->requirePresence('name', 'Input required')
            ->notEmptyString('name', 'Input required')
            ->maxLength('name', 255, 'Too long')
            ->requirePresence('phone', 'Input required')
            ->notEmptyString('phone', 'Input required')
            ->maxLength('phone', 12, 'Too long')
            ->requirePresence('sum', 'Input required')
            ->notEmptyString('sum', 'Input required')
            ->maxLength('sum', 255, 'Too long');
    }
}
