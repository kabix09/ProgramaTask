<?php

declare(strict_types=1);

namespace App\Infrastructure\GraphQL\Mutation;

use App\Application\Task\Command\CreateTaskCommand;
use App\Domain\Task\TaskRepositoryInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class TaskMutation
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private TaskRepositoryInterface $taskRepository,
    ) {}

    public function create(Argument $args)
    {
        $command = new CreateTaskCommand(
            $args['title'],
            $args['description']
        );

        $envelope = $this->commandBus->dispatch($command);

        $tasks = $this->taskRepository->findAll();
        return end($tasks) ?: null;
    }
}
