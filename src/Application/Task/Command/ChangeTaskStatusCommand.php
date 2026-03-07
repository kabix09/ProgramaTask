<?php

namespace App\Application\Task\Command;

use App\Domain\Task\TaskStatus;

readonly class ChangeTaskStatusCommand
{
    public function __construct(
        public string $taskId,
        public TaskStatus $newStatus,
    ) {}
}
