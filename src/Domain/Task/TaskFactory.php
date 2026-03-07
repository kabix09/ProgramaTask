<?php

declare(strict_types=1);

namespace App\Domain\Task;

use Symfony\Component\Uid\Uuid;

class TaskFactory
{
    public function create(string $title, string $description): Task
    {
        if (empty($title)) {
            throw new \InvalidArgumentException("Task title cannot be empty.");
        }

        return new Task(Uuid::v4(), $title, $description);
    }
}
