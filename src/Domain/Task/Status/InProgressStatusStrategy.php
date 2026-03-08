<?php

declare(strict_types=1);

namespace App\Domain\Task\Status;

use App\Domain\Task\TaskStatus;

class InProgressStatusStrategy implements StatusValidationStrategyInterface
{
    public function canTransitionTo(string $currentStatus): bool
    {
        return $currentStatus === TaskStatus::TODO->value;
    }

    public function getSupportedStatus(): string
    {
        return TaskStatus::IN_PROGRESS->value;
    }
}
