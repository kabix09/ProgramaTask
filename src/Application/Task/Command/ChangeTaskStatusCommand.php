<?php

namespace App\Application\Task\Command;

readonly class ChangeTaskStatusCommand
{
    public function __construct(
        public string $taskId,
        public string $newStatus
    ) {}
}
