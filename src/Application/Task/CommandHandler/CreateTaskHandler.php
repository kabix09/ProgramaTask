<?php

declare(strict_types=1);

namespace App\Application\Task\CommandHandler;

use App\Application\Task\Command\CreateTaskCommand;
use App\Domain\Task\TaskFactory;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler(bus: 'command.bus')]
class CreateTaskHandler
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
        private readonly MessageBusInterface $eventBus,
        private readonly TaskFactory $taskFactory,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(CreateTaskCommand $command): void
    {
        if ($command->assignedUserId !== null) {
            $assignedUser = $this->userRepository->find(Uuid::fromString($command->assignedUserId));

            if (!$assignedUser) {
                throw new \InvalidArgumentException("Assigned user not found.");
            }
        }

        $task = $this->taskFactory->create(
            $command->title,
            $command->description,
            $assignedUser,
        );

        $this->taskRepository->save($task);

        foreach ($task->pullEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
