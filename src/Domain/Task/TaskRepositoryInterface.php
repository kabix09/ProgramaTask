<?php

declare(strict_types=1);

namespace App\Domain\Task;

use Symfony\Component\Uid\Uuid;

interface TaskRepositoryInterface
{
    public function save(Task $task): void;
    public function findById(Uuid $id): ?Task;
    public function findAll(): array;
}
