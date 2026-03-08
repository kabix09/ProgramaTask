<?php

declare(strict_types=1);

namespace App\Domain\Task\Status;

interface StatusValidationStrategyInterface
{
    public function canTransitionTo(string $currentStatus): bool;
    public function getSupportedStatus(): string;
}
