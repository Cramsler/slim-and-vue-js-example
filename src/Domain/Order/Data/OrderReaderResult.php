<?php

namespace App\Domain\Order\Data;

/**
 * DTO.
 */
final class OrderReaderResult
{
    public ?int $id = null;

    public ?string $name = null;

    public ?string $phone = null;

    public ?string $sum = null;
}
