<?php

declare(strict_types=1);

namespace App\Domain\Task;

use Symfony\Component\Uid\Uuid;

class TaskFactory
{
    public function create(string $title, string $description, ?string $userId = null): Task
    {
        if (empty($title)) {
            throw new \InvalidArgumentException("Task title cannot be empty.");
        }

        $task = new Task(Uuid::v4(), $title, $description);

        if ($userId !== null) {
            $task->assignUser(Uuid::fromString($userId));
        }

        return $task;
    }
}
