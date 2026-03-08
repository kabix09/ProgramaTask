<?php

declare(strict_types=1);

namespace App\Infrastructure\GraphQL\Mutation;

use App\Application\Task\Command\ChangeTaskStatusCommand;
use App\Application\Task\Command\CreateTaskCommand;
use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Task\TaskStatus;
use Overblog\GraphQLBundle\Definition\Argument;
use Symfony\Component\Messenger\MessageBusInterface;

class TaskMutation
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private TaskRepositoryInterface $taskRepository,
    ) {
    }

    public function create(Argument $args): ?Task
    {
        $command = new CreateTaskCommand(
            $args['title'],
            $args['description'],
            $args['userId'] ?? null,
        );

        $envelope = $this->commandBus->dispatch($command);

        $tasks = $this->taskRepository->findAll();
        return end($tasks) ?: null;
    }

    public function changeStatus(string $id, string $status): ?Task
    {
        $enumStatus = TaskStatus::from($status);

        $this->commandBus->dispatch(new ChangeTaskStatusCommand($id, $enumStatus));
        return $this->taskRepository->find($id);
    }
}
