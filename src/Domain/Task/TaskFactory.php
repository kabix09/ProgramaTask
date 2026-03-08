<?php

declare(strict_types=1);

namespace App\Domain\Task;

use App\Domain\User\User;
use Symfony\Component\Uid\Uuid;

class TaskFactory
{
    public function create(string $title, string $description, ?User $assignedUser = null): Task
    {
        if (empty(trim($title))) {
            throw new \InvalidArgumentException("Task title cannot be empty.");
        }

        $task = new Task(Uuid::v4(), $title, $description, $assignedUser);

        return $task;
    }
}
