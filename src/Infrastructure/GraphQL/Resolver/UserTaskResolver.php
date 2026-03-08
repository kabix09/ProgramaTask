<?php

declare(strict_types=1);

namespace App\Infrastructure\GraphQL\Resolver;

use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;

class UserTaskResolver implements AliasedInterface
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {
    }

    /**
     * @return Task[]
     */
    public function resolve(Argument $args): array
    {
        $userId = $args['userId'];

        return $this->taskRepository->findBy(['user' => $userId]);
    }

    /**
     * @return string[]
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'user_task_list_by_id',
        ];
    }
}
