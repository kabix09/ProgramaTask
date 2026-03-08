<?php

declare(strict_types=1);

namespace App\Domain\Task;

use Doctrine\DBAL\LockMode;
use Symfony\Component\Uid\Uuid;

interface TaskRepositoryInterface
{
    public function save(Task $task): void;

    /**
     * @param mixed $id
     * @param LockMode|int|null $lockMode
     * @param int|null $lockVersion
     * @return Task|null
     */
    public function find(mixed $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): ?object;

    public function findById(Uuid $id): ?Task;

    /**
     * @return array<int, Task>
     */
    public function findAll(): array;
}
