<?php

declare(strict_types=1);

namespace App\Domain\Task\Status;

class DoneStatusStrategy implements StatusValidationStrategyInterface
{
    public function canTransitionTo(string $currentStatus): bool
    {
        return $currentStatus === 'IN_PROGRESS';
    }

    public function getSupportedStatus(): string
    {
        return 'DONE';
    }
}
