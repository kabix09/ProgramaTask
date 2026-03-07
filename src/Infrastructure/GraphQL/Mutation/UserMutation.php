<?php

declare(strict_types=1);

namespace App\Infrastructure\GraphQL\Mutation;

use App\Application\User\Command\SyncUsersCommand;
use Symfony\Component\Messenger\MessageBusInterface;

class UserMutation
{
    public function __construct(
        private MessageBusInterface $commandBus
    ) {}

    public function sync(): bool
    {
        try {
            $this->commandBus->dispatch(new SyncUsersCommand());
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
