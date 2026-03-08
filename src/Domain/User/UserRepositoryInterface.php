<?php

declare(strict_types=1);

namespace App\Domain\User;

interface UserRepositoryInterface
{
    /** @return User|null */
    public function findByExternalId(int $externalId): ?User;
    public function save(User $user): void;
}
