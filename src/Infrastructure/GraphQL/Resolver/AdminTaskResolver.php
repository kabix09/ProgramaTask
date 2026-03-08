<?php

namespace App\Infrastructure\GraphQL\Resolver;

use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminTaskResolver implements AliasedInterface
{
    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * @return Task[]
     */
    public function resolve(): array
    {
        return $this->taskRepository->findAll();
    }

    /**
     * @return string[]
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'admin_task_list',
        ];
    }
}
