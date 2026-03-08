<?php

declare(strict_types=1);

namespace App\Domain\User;

use Doctrine\DBAL\LockMode;

interface UserRepositoryInterface
{
    /**
     * @param mixed $id
     * @param LockMode|int|null $lockMode
     * @param int|null $lockVersion
     * @return User|null
     */
    public function find(mixed $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): ?object;

    /** @return User|null */
    public function findByExternalId(int $externalId): ?User;
    public function save(User $user): void;
}
