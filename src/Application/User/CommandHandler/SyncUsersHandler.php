<?php

declare(strict_types=1);

namespace App\Application\User\CommandHandler;

use App\Application\User\Command\SyncUsersCommand;
use App\Domain\User\UserFactory;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\ExternalApi\JsonPlaceholderClient;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SyncUsersHandler
{
    public function __construct(
        private JsonPlaceholderClient $apiClient,
        private UserFactory $userFactory,
        private UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(SyncUsersCommand $command): void
    {
        $externalData = $this->apiClient->fetchExternalUsers();

        foreach ($externalData as $userData) {
            $existingUser = $this->userRepository->findByExternalId((int)$userData['id']);

            if ($existingUser) {
                continue;
            }

            $user = $this->userFactory->createFromApi($userData);
            $this->userRepository->save($user);
        }
    }
}
