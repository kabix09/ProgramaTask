<?php

declare(strict_types=1);

namespace App\Application\Task\CommandHandler;

use App\Application\Task\Command\ChangeTaskStatusCommand;
use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class ChangeTaskStatusHandler
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private MessageBusInterface $eventBus
    ) {}

    public function __invoke(ChangeTaskStatusCommand $command): void
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($command->taskId);

        if (!$task) {
            throw new \InvalidArgumentException("Task not found");
        }

        $task->changeStatus($command->newStatus);

        $this->taskRepository->save($task);

        foreach ($task->pullEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
