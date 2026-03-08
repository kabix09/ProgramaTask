<?php

declare(strict_types=1);

namespace App\Domain\User;

use Symfony\Component\Uid\Uuid;

class UserFactory
{
    public function createFromApi(array $data): User
    {
        return new User(
            Uuid::v4(),
            $data['id'],
            $data['name'],
            $data['email']
        );
    }

    public function createLocalUser(string $email, string $name, array $roles = ['ROLE_USER']): User
    {
        return new User(
            Uuid::v4(),
            0,
            $name,
            $email,
            $roles
        );
    }
}
