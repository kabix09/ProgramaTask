<?php

declare(strict_types=1);

namespace App\Application\Task\CommandHandler;

use App\Application\Task\Command\CreateTaskCommand;
use App\Domain\Task\TaskFactory;
use App\Domain\Task\TaskRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler(bus: 'command.bus')]
class CreateTaskHandler
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
        private readonly MessageBusInterface $eventBus,
        private readonly TaskFactory $taskFactory,
    ) {
    }

    public function __invoke(CreateTaskCommand $command): void
    {
        $task = $this->taskFactory->create(
            $command->title,
            $command->description,
            $command->assignedUserId,
        );

        $this->taskRepository->save($task);

        foreach ($task->pullEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
